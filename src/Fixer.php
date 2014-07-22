<?php

namespace Steve\Renamespacer;

use Symfony\Component\Finder\Finder;

class Fixer
{
    protected $fixers = [];

    public function __construct()
    {
        $this->registerBuiltInFixers();
    }

    public function registerBuiltInFixers()
    {
        foreach (Finder::create()->files()->in(__DIR__ . '/Fixer') as $file) {
            $class = 'Steve\\Renamespacer\\Fixer\\' . basename($file, '.php');
            $this->addFixer(new $class());
        }
    }

    public function registerCustomFixers($fixers)
    {
        foreach ($fixers as $fixer) {
            $this->addFixer($fixer);
        }
    }

    public function addFixer(FixerInterface $fixer)
    {
        $this->fixers[] = $fixer;
    }

    public function getFixers()
    {
        $this->sortFixers();

        return $this->fixers;
    }

    public function fix(TokenCollection $document)
    {
        foreach ($this->getFixers() as $fixer) {
            $fixer->fix($document);
        }
    }

    private function sortFixers()
    {
        usort($this->fixers, function ($a, $b) {
            if ($a->getPriority() == $b->getPriority()) {
                return 0;
            }

            return $a->getPriority() > $b->getPriority() ? -1 : 1;
        });
    }

    private function prepareFixers(ConfigInterface $config)
    {
        $fixers = $config->getFixers();

        foreach ($fixers as $fixer) {
            if ($fixer instanceof ConfigAwareInterface) {
                $fixer->setConfig($config);
            }
        }

        return $fixers;
    }
}

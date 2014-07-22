<?php

namespace Steve\Renamespacer;

class Document
{
    private $namespace;

    private $namespaces;

    private $tokens = [];

    public function __construct($file)
    {
        $this->file = $file;

        foreach (token_get_all($file->getContents()) as $i => $rawtoken) {
            $this->tokens[$i] = new Token($rawtoken, $this, $i);
        }
    }

    public function __toString()
    {
        return (string) $this->getContent();
    }

    public function getContent()
    {
        $content = implode('', $this->getTokens());

        $content = $this->patch($content);

        return $content;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getNamespaces()
    {
        sort($this->namespaces);

        return $this->namespaces;
    }

    public function setNamespaces($namespaces)
    {
        $this->namespaces = $namespaces;

        return $this;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    private function patch($content)
    {
        $block = null;

        if ($this->getNamespace()) {
            $block = 'namespace ' . $this->getNamespace() . ';';
        } elseif ($this->getNamespaces()) {
            $block = "/**
 * php-renamespacer namespace candidates
 *
";

            foreach ($this->getNamespaces() as $namespace) {
                $block .= ' * namespace ' . $namespace . ';' . PHP_EOL;
            }

            $block .= ' */';
        }

        if ($block) {
            $content = preg_replace('#<\?php\s+#', "<?php\n\n$block\n\n", $content);
        }

        return $content;
    }
}

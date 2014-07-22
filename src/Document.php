<?php

namespace Steve\Renamespacer;

class Document
{
    public $namespace;

    private $tokens = [];

    public function __construct($string)
    {
        foreach (token_get_all($string) as $i => $rawtoken) {
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

    public function getTokens()
    {
        return $this->tokens;
    }

    private function patch($content)
    {
        $nsBlock = null;

        if ($this->namespace) {
            $nsBlock = 'namespace ' . $this->namespace . ';';
        } elseif ($this->namespaces) {
            sort($this->namespaces);

            $nsBlock = "/**
 * php-renamespacer namespace candidates
 *
";

            foreach ($this->namespaces as $namespace) {
                $nsBlock .= ' * namespace ' . $namespace . ';' . PHP_EOL;
            }

            $nsBlock .= ' */';
        }

        if ($nsBlock) {
            $content = preg_replace('#<\?php\s+#', "<?php\n\n$nsBlock\n\n", $content);
        }

        return $content;
    }
}

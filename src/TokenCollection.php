<?php

namespace Steve\Renamespacer;

class TokenCollection
{
    public $namespace;

    private $tokens;

    public function __construct($rawtokens)
    {
        $this->tokens = [];

        foreach ($rawtokens as $i => $rawtoken) {
            $this->tokens[$i] = new Token($rawtoken, $this, $i);
        }
    }

    public function getTokens()
    {
        return $this->tokens;
    }
}

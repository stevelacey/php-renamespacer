<?php

namespace Steve\Renamespacer;

class TokenParser
{
    public function parse($string)
    {
        return new TokenCollection(token_get_all($string));
    }
}

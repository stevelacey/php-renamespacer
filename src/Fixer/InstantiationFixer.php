<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\AbstractFixer;
use Steve\Renamespacer\TokenCollection;

class InstantiationFixer extends AbstractFixer
{
    public function fix(TokenCollection $document)
    {
        foreach ($document->getTokens() as $token) {
            if ($token->isClassNameCandidate()) {
                $previous = $token->getPreviousSignificant();
                $next = $token->getNextSignificant();

                if ($previous && $previous->isPreClassToken() || $next && $next->isPostClassToken()) {
                    $this->rewrite($token);
                }
            }
        }
    }
}

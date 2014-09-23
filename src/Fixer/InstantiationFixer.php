<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\AbstractFixer;
use Steve\Renamespacer\Document;

class InstantiationFixer extends AbstractFixer
{
    public function fix(Document $document)
    {
        foreach ($document->getTokens() as $token) {
            if ($token->isClassNameCandidate()) {
                $previous = $token->getPreviousNonWhitespace();
                $next = $token->getNextNonWhitespace();

                if ($previous && $previous->isPreClassToken() || $next && $next->isPostClassToken()) {
                    $this->rewrite($token);
                }
            }
        }
    }
}

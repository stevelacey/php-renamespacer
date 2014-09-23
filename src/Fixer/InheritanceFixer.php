<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\AbstractFixer;
use Steve\Renamespacer\Document;

class InheritanceFixer extends AbstractFixer
{
    public function fix(Document $document)
    {
        foreach ($document->getTokens() as $token) {
            if (in_array($token->getIndex(), [T_EXTENDS, T_IMPLEMENTS])) {
                $t = $token->getNext();

                while ($t && !in_array($t->getIndex(), [T_EXTENDS, T_IMPLEMENTS]) && $t->getContent() != '{') {
                    if ($t->isClassNameCandidate()) {
                        $this->rewrite($t);
                    }

                    $t = $t->getNext();
                }
            }
        }
    }
}

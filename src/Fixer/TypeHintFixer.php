<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\AbstractFixer;
use Steve\Renamespacer\TokenCollection;

class TypeHintFixer extends AbstractFixer
{
    public function fix(TokenCollection $document)
    {
        foreach ($document->getTokens() as $token) {
            if ($token->getIndex() == T_FUNCTION) {
                $t = $token;

                while ($t && $t->getContent() != '(') {
                    $t = $t->getNext();
                }

                while ($t && $t->getContent() != ')') {
                    if ($t->isClassNameCandidate()) {
                        $this->rewrite($t);
                    }

                    $t = $t->getNext();
                }
            }
        }
    }
}

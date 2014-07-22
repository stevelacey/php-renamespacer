<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\FixerInterface;
use Steve\Renamespacer\TokenCollection;

class TypeHintFixer implements FixerInterface
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
                        $t->setContent('\\' . str_replace('_', '\\', $t->getContent()));
                    }

                    $t = $t->getNext();
                }
            }
        }
    }

    public function getPriority()
    {
        return 0;
    }
}

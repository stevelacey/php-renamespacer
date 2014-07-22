<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\FixerInterface;
use Steve\Renamespacer\TokenCollection;

class InstantiationFixer implements FixerInterface
{
    public function fix(TokenCollection $document)
    {
        foreach ($document->getTokens() as $token) {
            if ($token->isClassNameCandidate()) {
                if (
                    $token->getPreviousSignificant() && $token->getPreviousSignificant()->isPreClassToken() ||
                    $token->getNextSignificant() && $token->getNextSignificant()->isPostClassToken()
                ) {
                    $fqcn = str_replace('_', '\\', $token->getContent());

                    if ($document->namespace) {
                        $ncn = preg_replace('#^' . preg_quote($document->namespace . '\\') . '#', '', $fqcn);

                        if ($ncn && $fqcn != $ncn) {
                            $token->setContent($ncn);
                        } else {
                            $token->setContent('\\' . $fqcn);
                        }
                    } else {
                        $token->setContent('\\' . $fqcn);
                    }
                }
            }
        }
    }

    public function getPriority()
    {
        return -10;
    }
}

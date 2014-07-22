<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\FixerInterface;
use Steve\Renamespacer\TokenCollection;

class DeclarationFixer implements FixerInterface
{
    public function fix(TokenCollection $document)
    {
        $document->namespaces = [];

        foreach ($document->getTokens() as $token) {
            if ($token->isClassNameCandidate()) {
                if ($token->getPreviousSignificant() && $token->getPreviousSignificant()->isDeclaration()) {
                    $segments = explode('_', $token->getContent());
                    $class = array_pop($segments);
                    $namespace = implode('\\', $segments);

                    if ($namespace && !in_array($namespace, $document->namespaces)) {
                        $document->namespaces[] = $namespace;
                    }

                    $token->setContent($class);
                }
            }
        }

        if (count($document->namespaces) === 1) {
            $document->namespace = $document->namespaces[0];
        }
    }

    public function getPriority()
    {
        return 10;
    }
}

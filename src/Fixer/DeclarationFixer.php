<?php

namespace Steve\Renamespacer\Fixer;

use Steve\Renamespacer\AbstractFixer;
use Steve\Renamespacer\Document;

class DeclarationFixer extends AbstractFixer
{
    public function fix(Document $document)
    {
        $namespaces = [];

        foreach ($document->getTokens() as $token) {
            if ($token->isClassNameCandidate()) {
                if ($token->getPreviousSignificant() && $token->getPreviousSignificant()->isDeclaration()) {
                    $segments = explode('_', $token->getContent());
                    $class = array_pop($segments);
                    $namespace = implode('\\', $segments);

                    if ($namespace && !in_array($namespace, $namespaces)) {
                        $namespaces[] = $namespace;
                    }

                    $token->setContent($class);
                }
            }
        }

        $document->setNamespaces($namespaces);

        if (count($namespaces) === 1) {
            $document->setNamespace($namespaces[0]);
        }
    }

    public function getPriority()
    {
        return 10;
    }
}

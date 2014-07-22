<?php

namespace Steve\Renamespacer;

abstract class AbstractFixer implements FixerInterface
{
    public function getPriority()
    {
        return 0;
    }

    protected function rewrite(Token $token)
    {
        $fqcn = str_replace('_', '\\', $token->getContent());

        $token->setContent('\\' . $fqcn);

        $namespace = $token->getDocument()->getNamespace();

        if ($namespace) {
            $ncn = preg_replace('#^' . preg_quote($namespace . '\\') . '#', '', $fqcn);

            if ($ncn && $fqcn != $ncn) {
                $token->setContent($ncn);
            }
        }
    }
}

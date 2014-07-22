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

        if ($token->getCollection()->namespace) {
            $ncn = preg_replace('#^' . preg_quote($token->getCollection()->namespace . '\\') . '#', '', $fqcn);

            if ($ncn && $fqcn != $ncn) {
                $token->setContent($ncn);
            }
        }
    }
}

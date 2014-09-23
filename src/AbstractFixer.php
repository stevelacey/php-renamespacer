<?php

namespace Steve\Renamespacer;

abstract class AbstractFixer implements FixerInterface
{
    private $reserved = array(
        '__halt_compiler', 'abstract', 'and', 'array', 'as', 'break',
        'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue',
        'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty',
        'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile',
        'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function',
        'global', 'goto', 'if', 'implements', 'include', 'include_once',
        'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace',
        'new', 'or', 'parent', 'print', 'private', 'protected', 'public', 'require',
        'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try',
        'unset', 'use', 'var', 'while', 'xor'
    );

    public function getPriority()
    {
        return 0;
    }

    protected function rewrite(Token $token)
    {
        $fqcn = $token->getContent();

        if (strpos($token->getContent(), 'PHPUnit') === false) {
            $fqcn = $this->unreserve($this->desnake($fqcn));
        }

        $token->setContent('\\' . $fqcn);

        $namespace = $token->getDocument()->getNamespace();

        if ($namespace) {
            $ncn = preg_replace('#^' . preg_quote($namespace . '\\') . '#', '', $fqcn);

            if ($ncn && $fqcn != $ncn) {
                $token->setContent($ncn);
            }
        }
    }

    protected function desnake($class)
    {
        return str_replace('_', '\\', $class);
    }

    protected function unreserve($class)
    {
        $class = implode('\\', array_map(
            function ($segment) {
                if (in_array(strtolower($segment), $this->reserved)) {
                    $segment .= '_';
                }

                return $segment;
            },
            explode('\\', $class)
        ));

        return $class;
    }
}

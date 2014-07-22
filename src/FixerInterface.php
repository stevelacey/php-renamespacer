<?php

namespace Steve\Renamespacer;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface FixerInterface
{
    public function fix(TokenCollection $tokens);

    /**
     * Returns the priority of the fixer.
     *
     * The default priority is 0 and higher priorities are executed first.
     */
    public function getPriority();
}

<?php

declare(strict_types=1);

namespace Ray\Di;

use Ray\Aop\MethodInvocation;
use Ray\Di\Exception\MethodInvocationNotAvailable;

class MethodInvocationProvider implements ProviderInterface
{
    /**
     * @var null|MethodInvocation
     */
    private $invocation;

    public function set(MethodInvocation $invocation)
    {
        $this->invocation = $invocation;
    }

    public function get() : MethodInvocation
    {
        if ($this->invocation === null) {
            throw new MethodInvocationNotAvailable;
        }

        return $this->invocation;
    }
}

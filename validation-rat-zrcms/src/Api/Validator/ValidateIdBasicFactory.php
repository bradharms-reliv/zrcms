<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Psr\Container\ContainerInterface;

/**
 * @todo This may not be needed
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIdBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateIdBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateIdBasic();
    }
}

<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByFieldsModelNameFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsByFieldsModelName
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsByFieldsModelName(
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateByFieldTypeRequired::class),
            $serviceContainer->get(ValidateByFieldType::class),
            $serviceContainer->get(ValidateByFieldConfigValidator::class),
            ValidateFieldsByFieldsModelName::DEFAULT_INVALID_CODE
        );
    }
}

<?php

namespace Zrcms\ServiceAlias;

use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;
use Zrcms\ServiceAlias\Api\Validator\ValidateIsZrcmsServiceAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigFields
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== Field Types =====
             */
            'field-rat-field-types' => [
                'zrcms-service' => [
                    'validator' => ValidateIsZrcmsServiceAlias::class,
                    'validator-options' => [
                        // @todo this must be set for full validation
                        // @todo it will pass if left null and value is string
                        ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE => null
                    ],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
            ],
        ];
    }
}

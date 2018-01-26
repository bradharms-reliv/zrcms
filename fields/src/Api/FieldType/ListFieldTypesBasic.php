<?php

namespace Zrcms\Fields\Api\FieldType;

use Zrcms\Fields\Model\FieldTypeBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ListFieldTypesBasic implements ListFieldTypes
{
    protected $fieldTypesConfig;

    /**
     * @param array $fieldTypesConfig
     */
    public function __construct(
        array $fieldTypesConfig
    ) {
        $this->fieldTypesConfig = $fieldTypesConfig;
    }

    /**
     * @param array $options
     *
     * @return FieldType[]
     */
    public function __invoke(
        array $options = []
    ): array {
        $fieldTypes = [];

        foreach ($this->fieldTypesConfig as $name => $fieldTypeConfig) {
            $fieldTypes[] = new FieldTypeBasic(
                $name,
                $fieldTypeConfig
            );
        }

        return $fieldTypes;
    }
}

<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Reliv\Json\Json;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryRcmPluginBc implements ReadComponentRegistry
{
    /**
     * @param       $appConfig
     * @param array $componentRegistry
     *
     * @return array
     * @throws \Exception
     */
    public static function invoke($appConfig, $componentRegistry = []): array
    {
        foreach ($appConfig['rcmPlugin'] as $rcmPluginName => $rcmPluginConfig) {
            $componentRegistry['block.' . $rcmPluginName]
                = ReadComponentConfigBlockBc::READER_SCHEME . ':' . $rcmPluginName;
        }

        foreach ($appConfig['Rcm']['blocks'] as $rcmPluginBlockConfigDir) {
            $rcmPluginBlockConfigDir = realpath($rcmPluginBlockConfigDir);
            $rcmPluginConfigJson = file_get_contents(
                realpath($rcmPluginBlockConfigDir . '/block.json')
            );

            $rcmPluginConfig = Json::decode(
                $rcmPluginConfigJson,
                true,
                512,
                0,
                'Received invalid JSON from file: ' . $rcmPluginConfigJson
            );

            $rcmPluginName = Property::getRequired(
                $rcmPluginConfig,
                FieldsComponentConfig::NAME
            );

            $componentRegistry['block.' . $rcmPluginName]
                = ReadComponentConfigJsonFileBc::READER_SCHEME . ':' . $rcmPluginBlockConfigDir . '/block.json';
        }

        return $componentRegistry;
    }

    /**
     * @var array
     */
    protected $appConfig;

    /**
     * @param array $appConfig
     */
    public function __construct(
        array $appConfig
    ) {
        $this->appConfig = $appConfig;
    }

    /**
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $options = []
    ): array {
        return self::invoke($this->appConfig);
    }
}

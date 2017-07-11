<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlock implements \Zrcms\Core\Block\Api\FindBlock
{
    const CACHE_KEY = 'ConfigRepositoryJson';
    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ConfigFields
     */
    protected $configFields;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * Constructor.
     *
     * @param array        $registryConfig
     * @param Cache        $cache
     * @param ConfigFields $configFields
     */
    public function __construct(
        $registryConfig,
        $cache,
        ConfigFields $configFields
    ) {
        $this->registryConfig = $registryConfig;
        $this->cache = $cache;
        $this->configFields = $configFields;
    }

    /**
     * hasCache
     *
     * @return bool
     */
    protected function hasCache()
    {
        return ($this->cache->hasItem(self::CACHE_KEY));
    }

    /**
     * getCache
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->cache->getItem(self::CACHE_KEY);
    }

    /**
     * setCache
     *
     * @param array $configs
     *
     * @return void
     */
    protected function setCache($configs)
    {
        $this->cache->setItem(self::CACHE_KEY, $configs);
    }

    /**
     * getConfigs
     *
     * @return array|mixed
     */
    protected function getConfigs()
    {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $pluginConfigs = $this->readConfigs(
            $this->registryConfig
        );

        $configs = [];

        foreach ($pluginConfigs as $pluginConfig) {
            $config = $this->configFields->prepare(
                $pluginConfig
            );

            $configs[] = new ConfigBasic($config);
        }

        $this->setCache($configs);

        return $configs;
    }

    /**
     * readConfigs
     *
     * @param array $blockPaths
     *
     * @return array
     */
    protected function readConfigs(array $blockPaths)
    {
        $pluginConfigs = [];

        foreach ($blockPaths as $blockPath) {
            $pluginDir = $blockPath;
            $configFileName = $pluginDir . '/block.json';
            $configFileContents = file_get_contents($configFileName);
            $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);
            $config['directory'] = realpath($pluginDir);
            $pluginConfigs[$config['name']] = $config;
        }

        return $pluginConfigs;
    }

    /**
     * @param string   $name
     * @param array $options
     *
     * @return Block|null
     */
    public function __invoke(
        $name,
        array $options = []
    ) {

    }
}

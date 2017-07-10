<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Container\Api\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Container\Api\RenderContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutMustache implements RenderLayout
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindContainers
     */
    protected $findContainers;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindContainers     $findContainers
     */
    public function __construct(
        $serviceContainer,
        FindContainers $findContainers
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainers = $findContainers;
    }

    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $options = []
    ):string
    {
        $findContainerPathsByHtmlServiceName = $layout->getProperty(
            LayoutProperties::KEY_CONTAINER_PATHS_SERVICE,
            FindContainerPathsByHtml::class
        );

        /** @var FindContainerPathsByHtml $findContainerPathsByLayout */
        $findContainerPathsByHtml = $this->serviceContainer->get(
            $findContainerPathsByHtmlServiceName
        );

        $containerPaths = $findContainerPathsByHtml->__invoke(
            $layout->getHtml()
        );

        $containers = $this->findContainers->__invoke(

        )

        $containerHtml = [];

        /** @var Container $container */
        foreach ($containerPaths as $containerPath) {

            $container = '';

            $renderContainerServiceName = $container->getProperty(
                LayoutProperties::KEY_RENDER,
                RenderContainer::class
            );

            /** @var RenderContainer $renderContainer */
            $renderContainer = $this->serviceContainer->get(
                $renderContainerServiceName
            );

            $containerHtml[$containerPath] = $renderContainer->__invoke(
                $container
            );
        }

        $renderContainerServiceName = $page->getProperty(
            LayoutProperties::KEY_RENDER,
            RenderContainer::class
        );

        /** @var RenderContainer $renderContainer */
        $renderContainer = $this->serviceContainer->get(
            $renderContainerServiceName
        );

        $containerHtml[PATH] = $renderContainer->__invoke(
            $page
        );

        // @todo RENDER

        return '';
    }
}

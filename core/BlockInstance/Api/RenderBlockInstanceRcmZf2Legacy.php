<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Interop\Container\ContainerInterface;
use Rcm\Plugin\PluginInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Renderer\PhpRenderer;
use Rcm\Block\Renderer\Renderer;
use Zend\View\Helper\Placeholder\Container;

class RenderBlockInstanceRcmZf2Legacy implements RenderBlockInstance
{
//    protected $findBlock;
//
//    public function __construct(FindBlock $findBlock)
//    {
//        $this->findBlock = $findBlock;
//    }

    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * Constructor.
     *
     * @param ContainerInterface $serviceManager
     * @param PhpRenderer $renderer
     */
    public function __construct(ContainerInterface $serviceManager, PhpRenderer $renderer)
    {
        $this->serviceManager = $serviceManager;
        $this->renderer = $renderer;
    }

    /**
     * __invoke
     *
     * @param InstanceWithData $blockInstance
     *
     * @return string HTML
     */
    public function __invoke(BlockInstanceWith $blockInstance)
    {
        /** @var \Rcm\Plugin\PluginInterface $controller */
        $controller = $this->getPluginController($blockInstance->getName());

        $request = new Request();
        $response = new Response();
        $controller->setResponse($response);

        /** @var \Zend\Mvc\MvcEvent $event */
        $event = new MvcEvent();
        $event->setResponse($response);
        $event->setRequest($request);

        $controller->setEvent($event);
        $controller->setRequest($request);
        $controller->setResponse($response);

        $viewModel = $controller->renderInstance(
            $blockInstance->getId(),
            $blockInstance->getConfig()
        );

        if ($viewModel instanceof ResponseInterface) {
            //Contains exit() call!
            $this->handleResponseFromPluginController($viewModel, $blockInstance->getName());

            return '';
        }

        /** @var \Zend\View\Helper\Headlink $headLink */
        $headLink = $this->renderer->plugin('headlink');

        /** @var \Zend\View\Helper\HeadScript $headScript */
        $headScript = $this->renderer->plugin('headscript');

        $oldContainer = $headLink->getContainer();
        $linkContainer = new Container();
        $headLink->setContainer($linkContainer);

        $oldScriptContainer = $headScript->getContainer();
        $headScriptContainer = new Container();
        $headScript->setContainer($headScriptContainer);

        $html = $this->renderer->render($viewModel);
        $css = $headLink->getContainer()->getArrayCopy();
        $script = $headScript->getContainer()->getArrayCopy();

        $html = $headLink->toString() . $headScript->toString() . $html;

        //Put the old things back in the PhpRenderer so we don't damage whatever is was doing before us. (seems hacky)
        $headLink->setContainer($oldContainer);
        $headScript->setContainer($oldScriptContainer);

        return $html;
    }

    /**
     * Get an instantiated plugin controller
     *
     * @param string $pluginName Plugin Name
     *
     * @return PluginInterface
     * @throws \Rcm\Exception\InvalidPluginException
     * @throws \Rcm\Exception\RuntimeException
     */
    public function getPluginController($pluginName)
    {
        /*
         * Deprecated.  All controllers should come from the controller manager
         * now and not the service manager.
         *
         * @todo Remove if statement once plugins have been converted.
         */
        if ($this->serviceManager->has($pluginName)) {
            $serviceManager = $this->serviceManager;
        } else {
            $serviceManager = $this->serviceManager->get('ControllerLoader');
        }

        if (!$serviceManager->has($pluginName)) {
            throw new InvalidPluginException(
                "Plugin $pluginName is not loaded or configured. Check
            config/application.config.php"
            );
        }

        $pluginController = $serviceManager->get($pluginName);

        //Plugin controllers must implement this interface
        if (!$pluginController instanceof PluginInterface) {
            throw new InvalidPluginException(
                'Class "' . get_class($pluginController) . '" for plugin "'
                . $pluginName . '" does not implement '
                . '\Rcm\Plugin\PluginInterface'
            );
        }

        return $pluginController;
    }

    /**
     * Handles the legacy support for the odd case where plugin controllers return
     * zf2 responses instead of view models
     * @TODO remove all this and throw an exception if the plugin controller doesn't return a view model
     */
    public function handleResponseFromPluginController(ResponseInterface $response, $blockInstanceName)
    {
//        trigger_error(
//            'Returning responses from plugin controllers is no longer supported.
//                 The following plugin attempted this: ' . $blockInstanceName .
//            ' Post to your own route to avoid this problem.',
//            E_USER_WARNING
//        );

        foreach ($response->getHeaders() as $header) {
            header($header->toString());
        }

//        //Some plugins used to return responses like this to signal a redirect to the login page
//        if ($response->getStatusCode() == 401) {
//            $href = '/login?redirect=' . urlencode($request->getUri()->getPath());;
//            echo "You are not authorized to view this page. Try <a href=\"{$href}\">logging in</a> first.";
//            exit;
//        }

        echo $response->getContent();
        exit;
    }

//    /**
//     * Get a plugin instance rendered view.
//     *
//     * @param string $pluginName Plugin name
//     * @param integer $pluginInstanceId Plugin Instance Id
//     * @param null $forcedAlternativeInstanceConfig Not normally used. Useful for previewing changes
//     *
//     * @return array
//     * @throws \Rcm\Exception\InvalidPluginException
//     * @throws \Rcm\Exception\PluginReturnedResponseException
//     */
//    public function getPluginViewData(
//        $pluginName,
//        $pluginInstanceId,
//        $forcedAlternativeInstanceConfig = null
//    ) {
//        $request = ServerRequestFactory::fromGlobals();
//
//        $blockConfig = $this->blockConfigRepository->findById($pluginName);
//
//        if ($pluginInstanceId < 0) {
//            $instanceWithData = new InstanceWithDataBasic(
//                $pluginInstanceId,
//                $pluginName,
//                $blockConfig->getDefaultConfig(),
//                [] //@TODO run the dataprovider here instead of returning empty array
//            );
//        } else {
//            $instanceWithData = $this->instanceWithDataService->__invoke($pluginInstanceId, $request);
//        }
//
//        if ($forcedAlternativeInstanceConfig !== null) {
//            $instanceWithData = new InstanceWithDataBasic(
//                $instanceWithData->getId(),
//                $instanceWithData->getName(),
//                $forcedAlternativeInstanceConfig,
//                //@TODO we should have got the data from the data provider with the forced instance config as an input
//                $instanceWithData->getData()
//            );
//        }
//
//        $html = $this->blockRendererService->__invoke($instanceWithData);
//
//        /**
//         * @var $blockConfig Config
//         */
//
//        $return = [
//            'html' => $html,
//            'css' => [],
//            'js' => [],
//            'editJs' => '',
//            'editCss' => '',
//            'displayName' => $blockConfig->getLabel(),
//            'tooltip' => $blockConfig->getDescription(),
//            'icon' => $blockConfig->getIcon(),
//            'siteWide' => false, // @deprecated <deprecated-site-wide-plugin>
//            'md5' => '',
//            'fromCache' => false,
//            'canCache' => $blockConfig->getCache(),
//            'pluginName' => $blockConfig->getName(),
//            'pluginInstanceId' => $pluginInstanceId,
//        ];
//
//        return $return;
//    }
}

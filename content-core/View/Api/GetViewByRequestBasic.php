<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Exception\LayoutNotFoundException;
use Zrcms\ContentCore\Theme\Exception\ThemeNotFoundException;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Fields\FieldsView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestBasic implements GetViewByRequest
{
    /**
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindPageContainerCmsResourceBySitePath
     */
    protected $findPageContainerCmsResourceBySitePath;

    /**
     * @var FindLayoutCmsResourceByThemeNameLayoutName
     */
    protected $findLayoutCmsResourceByThemeNameLayoutName;

    /**
     * @var GetLayoutName
     */
    protected $getLayoutName;

    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @var GetViewLayoutTags
     */
    protected $getViewLayoutTags;

    /**
     * @var BuildView
     */
    protected $buildView;

    /**
     * @param FindSiteCmsResourceByHost                  $findSiteCmsResourceByHost
     * @param FindPageContainerCmsResourceBySitePath     $findPageContainerCmsResourceBySitePath
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     * @param GetLayoutName                              $getLayoutName
     * @param FindThemeComponent                         $findThemeComponent
     * @param GetViewLayoutTags                          $getViewLayoutTags
     * @param BuildView                                  $buildView
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName,
        GetLayoutName $getLayoutName,
        FindThemeComponent $findThemeComponent,
        GetViewLayoutTags $getViewLayoutTags,
        BuildView $buildView
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findPageContainerCmsResourceBySitePath = $findPageContainerCmsResourceBySitePath;
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
        $this->getLayoutName = $getLayoutName;

        $this->findThemeComponent = $findThemeComponent;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->buildView = $buildView;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws LayoutNotFoundException
     * @throws PageNotFoundException
     * @throws SiteNotFoundException
     * @throws ThemeNotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View
    {
        $uri = $request->getUri();

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            throw new SiteNotFoundException(
                'Site not found for host: (' . $uri->getHost() . ')'
            );
        }

        $themeName = $siteCmsResource->getContentVersion()->getThemeName();

        $themeComponent = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFoundException(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResource->getHost() . ')'
                . ' with site ID: (' . $siteCmsResource->getContentVersion()->getId() . ')'
            );
        }

        $path = $uri->getPath();

        /** @var PageContainerCmsResource $pageContainerCmsResource */
        $pageContainerCmsResource = $this->findPageContainerCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $path
        );

        if (empty($pageContainerCmsResource)) {
            throw new PageNotFoundException(
                'Page not found for host: (' . $uri->getHost() . ')'
                . ' and page: (' . $path . ')'
            );
        }

        $siteVersion = $siteCmsResource->getContentVersion();
        $pageContainerVersion = $pageContainerCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageContainerVersion
        );

        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
            $themeName,
            $layoutName
        );

        if (empty($layoutCmsResource)) {
            throw new LayoutNotFoundException(
                'Layout not found: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
                . ' for site version ID: (' . $siteVersion->getId() . ')'
                . ' and page version ID: (' . $pageContainerVersion->getId() . ')'
            );
        }

        $properties = [
            FieldsView::SITE_CMS_RESOURCE
            => $siteCmsResource,

            FieldsView::PAGE_CONTAINER_CMS_RESOURCE
            => $pageContainerCmsResource,

            FieldsView::LAYOUT_CMS_RESOURCE
            => $layoutCmsResource,
        ];

        $additionalProperties = Param::get(
            $options,
            self::OPTION_ADDITIONAL_PROPERTIES,
            []
        );

        $properties = array_merge(
            $additionalProperties,
            $properties
        );

        $view = new ViewBasic(
            $properties
        );

        return $this->buildView->__invoke(
            $request,
            $view
        );
    }
}

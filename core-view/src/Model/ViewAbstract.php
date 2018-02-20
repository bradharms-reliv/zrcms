<?php

namespace Zrcms\CoreView\Model;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\Core\Model\PropertiesTrait;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Fields\FieldsView;

/**
 * ViewModel
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewAbstract extends ContentAbstract implements View
{
    use PropertiesTrait;

    protected $siteCmsResource;
    protected $pageCmsResource;
    protected $layoutCmsResource;

    /**
     * @param array $properties
     * @param null  $id
     *
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __construct(
        array $properties,
        $id = null
    ) {
        $this->siteCmsResource = Property::getRequired(
            $properties,
            FieldsView::SITE_CMS_RESOURCE,
            get_class($this)
        );

        $this->pageCmsResource = Property::getRequired(
            $properties,
            FieldsView::PAGE_CMS_RESOURCE,
            get_class($this)
        );

        $this->layoutCmsResource = Property::getRequired(
            $properties,
            FieldsView::LAYOUT_CMS_RESOURCE,
            get_class($this)
        );

        parent::__construct(
            $properties,
            $id
        );
    }

    /**
     * @return SiteCmsResource
     */
    public function getSiteCmsResource(): SiteCmsResource
    {
        return $this->siteCmsResource;
    }

    /**
     * @return PageCmsResource
     */
    public function getPageCmsResource(): PageCmsResource
    {
        return $this->pageCmsResource;
    }

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource
    {
        return $this->layoutCmsResource;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return View
     */
    public function withProperty(
        string $name,
        $value
    ): View {
        $properties = $this->properties;
        $properties[$name] = $value;

        return new static(
            $properties,
            $this->getId()
        );
    }
}

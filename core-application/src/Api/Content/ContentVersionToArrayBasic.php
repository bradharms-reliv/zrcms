<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplication\Api\RemoveProperties;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionToArrayBasic implements ContentVersionToArray
{
    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return array
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): array {
        $array = [];

        $array['id'] = $contentVersion->getId();
        $array['properties'] = $contentVersion->getProperties();
        $array['createdByUserId'] = $contentVersion->getCreatedByUserId();
        $array['createdReason'] = $contentVersion->getCreatedReason();
        $array['createdDate'] = $contentVersion->getCreatedDate();

        return RemoveProperties::invoke(
            $array,
            Property::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}

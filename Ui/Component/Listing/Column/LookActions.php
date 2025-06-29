<?php

/**
 * File: LookActions.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */

namespace Juszczyk\ShopTheLook\Ui\Component\Listing\Column;

use Juszczyk\ShopTheLook\Api\Data\LookInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class LookActions extends Column
{
    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[LookInterface::LOOK_ID])) {
                    $item[$name]['edit'] = $this->getEditAction($item);
                    $item[$name]['delete'] = $this->getDeleteAction($item);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $item
     * @return array
     */
    protected function getEditAction($item): array
    {
        return [
            'href' => $this->context->getUrl(
                'shopthelook/look/edit',
                ['look_id' => $item['look_id']]
            ),
            'label' => __('Edit')->render()
        ];
    }

    /**
     * @param $item
     * @return array
     */
    protected function getDeleteAction($item): array
    {
        return [
            'href' => $this->context->getUrl(
                'shopthelook/look/delete',
                ['look_id' => $item['look_id']]
            ),
            'label' => __('Delete')->render(),
            'confirm' => [
                'title' => __('Delete %1', $item['name'])->render(),
                'message' => __('Are you sure you want to delete a %1 record?', $item['name'])->render()
            ]
        ];
    }
}

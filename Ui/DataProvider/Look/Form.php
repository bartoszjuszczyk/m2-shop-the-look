<?php

/**
 * File: Look.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Ui\DataProvider\Look;

use Juszczyk\ShopTheLook\Api\Data\LookInterface;
use Juszczyk\ShopTheLook\Model\ResourceModel\Look\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Form extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected array $loadedData = [];

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param DataPersistorInterface $dataPersistor
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        protected readonly DataPersistorInterface $dataPersistor,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (! empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        if (empty($items)) {
            $this->loadedData[null] = [];
        }

        /** @var LookInterface $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getLookId()] = $item->getData();
        }

        $data = $this->dataPersistor->get('shopthelook_look');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[null] = $item->getData();
            $this->dataPersistor->clear('shopthelook_look');
        }

        return $this->loadedData;
    }
}

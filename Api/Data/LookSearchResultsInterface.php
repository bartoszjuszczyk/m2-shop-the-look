<?php

/**
 * File: LookSearchResultsInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2025.
 **/

declare(strict_types=1);

namespace Juszczyk\ShopTheLook\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LookSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items
     *
     * @return LookInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param LookInterface[] $items
     * @return self
     */
    public function setItems(array $items);
}

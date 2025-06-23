<?php
declare(strict_types=1);

/**
 * File: Collection.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */

namespace Juszczyk\ShopTheLook\Model\ResourceModel\Look;

use Juszczyk\ShopTheLook\Model\ResourceModel\Look;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'look_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(
            \Juszczyk\ShopTheLook\Model\Look::class,
            Look::class
        );
    }
}

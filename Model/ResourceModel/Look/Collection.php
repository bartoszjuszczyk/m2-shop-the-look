<?php
declare(strict_types=1);

/**
 * File: Collection.php
 *
 * @author Bartosz Juszczyk <bartosz.juszczyk@ageno.pl>
 * @copyright Copyright (C) 2025 Ageno (https://ageno.pl)
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

<?php
declare(strict_types=1);

/**
 * File: Look.php
 *
 * @author Bartosz Juszczyk <bartosz.juszczyk@ageno.pl>
 * @copyright Copyright (C) 2025 Ageno (https://ageno.pl)
 */

namespace Juszczyk\ShopTheLook\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Look extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('juszczyk_shopthelook_look', 'look_id');
    }
}

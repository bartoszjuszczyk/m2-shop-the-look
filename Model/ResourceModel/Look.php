<?php
declare(strict_types=1);

/**
 * File: Look.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */

namespace Juszczyk\ShopTheLook\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Look extends AbstractDb
{
    private const string LOOK_STORE_TABLE = 'juszczyk_shopthelook_look_store';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('juszczyk_shopthelook_look', 'look_id');
    }

    /**
     * @inheritDoc
     */
    protected function _afterLoad(AbstractModel $object): self
    {
        if (! $object->getId()) {
            return parent::_afterLoad($object);
        }
        $storeIds = $this->getStoreIds((int) $object->getId());
        $object->setData('store_ids', $storeIds);

        return parent::_afterLoad($object);
    }

    /**
     * Get store IDs from relation table.
     *
     * @param int $lookId
     * @return array
     */
    protected function getStoreIds(int $lookId): array
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from(
                $connection->getTableName(self::LOOK_STORE_TABLE),
                ['store_id']
            )
            ->where('look_id = ?', $lookId);
        $storeIds = $connection->fetchCol($select);

        return array_map('intval', $storeIds);
    }
}

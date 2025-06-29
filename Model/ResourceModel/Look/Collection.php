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
use Magento\Store\Model\Store;

class Collection extends AbstractCollection
{
    private const string LOOK_STORE_TABLE = 'juszczyk_shopthelook_look_store';

    private const string STORES_RELATION_JOINED_FLAG = 'stores_relation_joined';

    /**
     * @var string
     */
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
        $this->addFilterToMap('look_id', 'main_table.look_id');
    }

    /**
     * Join stores relation.
     *
     * @return void
     */
    protected function joinStoresRelation(): void
    {
        $this->getSelect()->joinLeft(
            ['store_table' => $this->getTable(self::LOOK_STORE_TABLE)],
            'main_table.look_id = store_table.look_id',
            []
        )->group(
            'main_table.look_id'
        );

        $this->setFlag(self::STORES_RELATION_JOINED_FLAG, true);
    }

    /**
     * @inheritDoc
     */
    protected function _renderFiltersBefore(): void
    {
        if ($this->getFlag(self::STORES_RELATION_JOINED_FLAG)) {
            return;
        }
        $this->joinStoresRelation();
        $this->addFilterToMap('store_id', 'store_table.store_id');
        parent::_renderFiltersBefore();
    }

    /**
     * @inheritDoc
     */
    protected function _afterLoad(): void
    {
        $this->attachStores();
    }

    /**
     * Add store filter.
     *
     * @param mixed $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter(mixed $store, bool $withAdmin = true): self
    {
        if (!$this->isLoaded()) {
            if ($store instanceof Store) {
                $store = [$store->getId()];
            }

            if (!is_array($store)) {
                $store = [$store];
            }

            if ($withAdmin) {
                $store[] = Store::DEFAULT_STORE_ID;
            }

            $linkTable = $this->getTable('juszczyk_shopthelook_look_store');

            $this->getSelect()->join(
                ['store_table' => $linkTable],
                'main_table.look_id = store_table.look_id',
                []
            )->where(
                'store_table.store_id IN (?)',
                $store
            )->group(
                'main_table.look_id'
            );
        }
        return $this;
    }

    /**
     * Attach stores relation.
     *
     * @return void
     */
    protected function attachStores(): void
    {
        $entityIds = $this->getColumnValues($this->_idFieldName);

        if (count($entityIds) === 0) {
            return;
        }

        $connection = $this->getConnection();
        $linkTable = $connection->getTableName(self::LOOK_STORE_TABLE);

        $select = $connection->select()
            ->from($linkTable, ['look_id', 'store_id'])
            ->where('look_id IN (?)', $entityIds);
        $result = $connection->fetchAll($select);

        $storesData = [];
        foreach ($result as $row) {
            $storesData[(int) $row['look_id']][] = (int) $row['store_id'];
        }

        foreach ($this as $item) {
            $entityId = (int) $item->getData($this->_idFieldName);
            if (isset($storesData[$entityId])) {
                $item->setData('store_id', $storesData[$entityId]);
            } else {
                $item->setData('store_id', []);
            }
        }
    }
}

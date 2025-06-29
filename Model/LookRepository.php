<?php
declare(strict_types=1);

/**
 * File: LookRepository.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */

namespace Juszczyk\ShopTheLook\Model;

use Exception;
use Juszczyk\ShopTheLook\Api\Data\LookInterface;
use Juszczyk\ShopTheLook\Api\Data\LookSearchResultsInterface;
use Juszczyk\ShopTheLook\Api\LookRepositoryInterface;
use Juszczyk\ShopTheLook\Model\ResourceModel\Look as LookResource;
use Juszczyk\ShopTheLook\Model\ResourceModel\Look\CollectionFactory as LookCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class LookRepository implements LookRepositoryInterface
{
    /**
     * @param LookResource $lookResource
     * @param LookFactory $lookFactory
     * @param LookCollectionFactory $lookCollectionFactory
     * @param LookSearchResultsInterface $lookSearchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        protected readonly LookResource $lookResource,
        protected readonly LookFactory $lookFactory,
        protected readonly LookCollectionFactory $lookCollectionFactory,
        protected readonly LookSearchResultsInterface $lookSearchResultsFactory,
        protected readonly CollectionProcessorInterface $collectionProcessor,
        protected readonly ResourceConnection $resourceConnection
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): LookInterface
    {
        $look =$this->lookFactory->create();
        $this->lookResource->load($look, $id);
        if (!$look->getId()) {
            throw new NoSuchEntityException(__('Look with id "%1" does not exist.', $id));
        }
        return $look;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): LookSearchResultsInterface
    {
        $collection = $this->lookCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->lookSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function save(LookInterface $look): LookInterface
    {
        try {
            $this->lookResource->save($look);
            $this->updateStoresRelation($look);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save look: %1', $e->getMessage()));
        }
        return $look;
    }

    /**
     * @inheritDoc
     */
    public function delete(LookInterface $look): bool
    {
        try {
            $this->lookResource->delete($look);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete look: %1', $e->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * Update stores relation.
     *
     * @param LookInterface $look
     * @return void
     */
    protected function updateStoresRelation(LookInterface $look): void
    {
        $connection = $this->resourceConnection->getConnection();
        $relationTable = $connection->getTableName('juszczyk_shopthelook_look_store');
        $lookId = $look->getId();
        $storeIds = $look->getStoreIds() ?: [];

        $connection->delete($relationTable, ['look_id = ?' => $lookId]);

        if (!empty($storeIds)) {
            $dataToInsert = [];
            foreach ($storeIds as $storeId) {
                $dataToInsert[] = [
                    'look_id' => $lookId,
                    'store_id' => (int)$storeId,
                ];
            }
            $connection->insertMultiple($relationTable, $dataToInsert);
        }
    }
}

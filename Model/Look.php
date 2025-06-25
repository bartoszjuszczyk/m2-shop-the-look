<?php

/**
 * File: Look.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2025.
 **/

declare(strict_types=1);

namespace Juszczyk\ShopTheLook\Model;

use Exception;
use Juszczyk\ShopTheLook\Api\Data\LookInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Look extends AbstractExtensibleModel implements LookInterface, IdentityInterface
{
    public const string CACHE_TAG = 'j_s_l';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $productCollectionFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly CollectionFactory $productCollectionFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Look::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG, self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getLookId(): int
    {
        return $this->getData(self::LOOK_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLookId(int $lookId): LookInterface
    {
        return $this->setData(self::LOOK_ID, $lookId);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): LookInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(?string $description): LookInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function setActive(bool $active): LookInterface
    {
        return $this->setData(self::IS_ACTIVE, $active);
    }

    /**
     * Get main product for look.
     *
     * @return ProductInterface|null
     */
    public function getMainProduct(): ?ProductInterface
    {
        try {
            $connection = $this->_resource->getConnection();
            $select = $connection->select()
                ->from(
                    $connection->getTableName('juszczyk_shopthelook_main_relation'),
                    ['product_id']
                )
                ->where('look_id = ?', $this->getLookId());
            $row = $connection->fetchRow($select);
            $productId = $row['product_id'];
            return $this->productRepository->getById((int)$productId);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get product IDs related to look.
     *
     * @return array
     */
    public function getProductIds(): array
    {
        $productIds = [];
        $connection = $this->_resource->getConnection();
        $select = $connection->select()
            ->from(
                $connection->getTableName('juszczyk_shopthelook_look_relation'),
                ['product_id']
            )
            ->where('look_id = ?', $this->getLookId());
        $rows = $connection->fetchAll($select);
        foreach ($rows as $row) {
            $productIds[] = (int) $row['product_id'];
        }

        return $productIds;
    }
}

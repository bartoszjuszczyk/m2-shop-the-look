<?php

/**
 * File: LookInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2025.
 **/

declare(strict_types=1);

namespace Juszczyk\ShopTheLook\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface LookInterface extends ExtensibleDataInterface
{
    public const string LOOK_ID = 'look_id';
    public const string NAME = 'name';
    public const string DESCRIPTION = 'description';
    public const string IS_ACTIVE = 'is_active';
    public const string STORE_IDS = 'store_ids';

    /**
     * Get Look ID.
     *
     * @return int
     */
    public function getLookId(): int;

    /**
     * Set Look ID.
     *
     * @param int $lookId
     * @return self
     */
    public function setLookId(int $lookId): self;

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set Name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Get Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set Description.
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self;

    /**
     * Is Active.
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Set Active.
     *
     * @param bool $active
     * @return self
     */
    public function setActive(bool $active): self;

    /**
     * Get Store Ids.
     *
     * @return array
     */
    public function getStoreIds(): array;

    /**
     * Set Store Ids.
     *
     * @param array $storeIds
     * @return self
     */
    public function setStoreIds(array $storeIds): self;
}

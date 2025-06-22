<?php

/**
 * File: LookRepositoryInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2025.
 **/

declare(strict_types=1);

namespace Juszczyk\ShopTheLook\Api;

use Juszczyk\ShopTheLook\Api\Data\LookInterface;
use Juszczyk\ShopTheLook\Api\Data\LookSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface LookRepositoryInterface
{
    /**
     * Get Look by ID.
     *
     * @param int $id
     * @return LookInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): LookInterface;

    /**
     * Get Looks by SearchCriteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LookSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): LookSearchResultsInterface;

    /**
     * Save Look.
     *
     * @param LookInterface $look
     * @return LookInterface
     * @throws CouldNotSaveException
     */
    public function save(LookInterface $look): LookInterface;

    /**
     * Delete Look.
     *
     * @param LookInterface $look
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(LookInterface $look): bool;

    /**
     * Delete Look by ID.
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}

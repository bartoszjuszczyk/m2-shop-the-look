<?php

/**
 * File: Delete.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Controller\Adminhtml\Look;

use Exception;
use Juszczyk\ShopTheLook\Api\LookRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param LookRepositoryInterface $lookRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        protected readonly LookRepositoryInterface $lookRepository,
        protected readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $lookId = $this->getRequest()->getParam('look_id');
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if ($lookId) {
            try {
                $this->lookRepository->deleteById((int) $lookId);
                $this->messageManager->addSuccessMessage(__('The look has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
                return $resultRedirect->setPath('*/*/edit', ['look_id' => $lookId]);
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete the store.'));
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
                return $resultRedirect->setPath('*/*/edit', ['look_id' => $lookId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a store to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Juszczyk_ShopTheLook::looks_edit');
    }
}

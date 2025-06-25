<?php

/**
 * File: Save.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Controller\Adminhtml\Look;

use Exception;
use Juszczyk\ShopTheLook\Api\LookRepositoryInterface;
use Juszczyk\ShopTheLook\Model\LookFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param LookRepositoryInterface $lookRepository
     * @param LookFactory $lookFactory
     * @param LoggerInterface $logger
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        protected readonly LookRepositoryInterface $lookRepository,
        protected readonly LookFactory $lookFactory,
        protected readonly LoggerInterface $logger,
        protected readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if ($data) {
            $lookId = $this->getRequest()->getParam('look_id');
            if ($lookId) {
                try {
                    $look = $this->lookRepository->getById((int) $lookId);
                } catch (LocalizedException $e) {
                    $this->dataPersistor->set('shopthelook_look', $data);
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $this->logger->error($e->getMessage());
                    $this->logger->error($e->getTraceAsString());
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $look = $this->lookFactory->create();
                $data['look_id'] = null;
            }

            $look->setData($data);

            try {
                $this->lookRepository->save($look);
                $this->messageManager->addSuccessMessage(__('You saved the store.'));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['look_id' => $look->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->dataPersistor->set('shopthelook_look', $data);
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['look_id' => $this->getRequest()->getParam('look_id')]);
            } catch (Exception $e) {
                $this->dataPersistor->set('shopthelook_look', $data);
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the look.'));
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['look_id' => $this->getRequest()->getParam('look_id')]);
            }
        }
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

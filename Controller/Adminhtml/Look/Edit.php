<?php

/**
 * File: Edit.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Controller\Adminhtml\Look;

use Juszczyk\ShopTheLook\Api\LookRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @param Context $context
     * @param LookRepositoryInterface $lookRepository
     */
    public function __construct(
        Context $context,
        protected readonly LookRepositoryInterface $lookRepository
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $lookId = $this->getRequest()->getParam('look_id');
        if ($lookId) {
            try {
                $look = $this->lookRepository->getById((int)$lookId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Look with id: %1 does not exist.', $lookId));
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
            }
        }
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->setActiveMenu('Juszczyk_ShopTheLook::manage_looks');
        $page->addBreadcrumb(__('Manage Looks'), __('Manage Looks'));
        $page->getConfig()->getTitle()->prepend(($lookId ? __('Edit Look: %1', $look->getName()) : __('New Look')));

        return $page;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Juszczyk_ShopTheLook::looks_edit');
    }
}

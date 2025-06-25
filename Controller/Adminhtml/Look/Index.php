<?php

/**
 * File: Index.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Controller\Adminhtml\Look;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->setActiveMenu('Juszczyk_ShopTheLook::manage_looks');
        $page->addBreadcrumb(__('Manage Looks'), __('Manage Looks'));
        $page->getConfig()->getTitle()->prepend(__('Manage Looks'));

        return $page;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Juszczyk_ShopTheLook::looks');
    }
}

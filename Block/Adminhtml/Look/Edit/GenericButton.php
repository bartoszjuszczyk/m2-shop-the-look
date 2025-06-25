<?php

/**
 * File: GenericButton.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (C) 2025
 */
namespace Juszczyk\ShopTheLook\Block\Adminhtml\Look\Edit;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @param UrlInterface $url
     */
    public function __construct(
        protected readonly UrlInterface $url,
        protected readonly RequestInterface $request
    ) {
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '*', array $params = []): string
    {
        return $this->url->getUrl($route, $params);
    }

    /**
     * @return int|null
     */
    public function getLookId(): ?int
    {
        $lookId = $this->request->getParam('look_id');
        if (! $lookId) {
            return null;
        }

        return (int) $lookId;
    }
}

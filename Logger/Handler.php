<?php

namespace Juszczyk\ShopTheLook\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Handler class.
 */
class Handler extends Base
{
    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * @var string
     */
    protected $fileName = '/var/log/shop_the_look.log';
}

<?php
declare(strict_types=1);

/**
 * File: LookSearchResults.php
 *
 * @author Bartosz Juszczyk <bartosz.juszczyk@ageno.pl>
 * @copyright Copyright (C) 2025 Ageno (https://ageno.pl)
 */

namespace Juszczyk\ShopTheLook\Model;

use Juszczyk\ShopTheLook\Api\Data\LookSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class LookSearchResults extends SearchResults implements LookSearchResultsInterface
{
}

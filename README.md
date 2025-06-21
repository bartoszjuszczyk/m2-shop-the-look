# Magento 2 - Shop the Look Module

<p>
    <a href="https://packagist.org/packages/juszczyk/m2-shop-the-look"><img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/juszczyk/m2-shop-the-look.svg?style=flat-square"></a>
    <a href="https://github.com/bartoszjuszczyk/m2-shop-the-look/actions"><img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/bartoszjuszczyk/m2-shop-the-look/ci.yml?branch=main&style=flat-square"></a>
    <a href="https://codeclimate.com/github/bartoszjuszczyk/m2-shop-the-look"><img alt="Code Coverage" src="https://img.shields.io/codeclimate/coverage/bartoszjuszczyk/m2-shop-the-look?style=flat-square"></a>
    <a href="https://github.com/bartoszjuszczyk/m2-shop-the-look/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/github/license/bartoszjuszczyk/m2-shop-the-look?style=flat-square"></a>
</p>

The **Shop the Look** module for Magento 2 is an advanced merchandising tool designed to increase Average Order Value (
AOV) and enhance the customer shopping experience. It allows store administrators to create and manage "looks" or "
stylizations" composed of multiple products, presenting them as a complete, shoppable set.

This project was developed as part of my portfolio to demonstrate advanced skills in Magento 2 development, including
data modeling, admin panel UI development, dynamic frontend interactions using AJAX, and adherence to modern coding best
practices.

## Main Features

### For the Administrator

* **Look Management:** A full CRUD (Create, Read, Update, Delete) interface to manage "looks" in a dedicated admin panel
  section.
* **Intuitive Product Selector:** A convenient product selector (UI Component Grid) to build and modify looks.
* **Flexible Assignment:** The ability to assign a single look to multiple main products via a new tab on the product
  edit page.
* **Full Control:** Easily activate or deactivate individual looks.

### For the Customer

* **Inspiring Presentation:** An attractive "Shop the Look" block displayed on the product detail page.
* **Seamless Shopping:** The ability to add multiple products (the entire look or selected items) to the cart with a *
  *single click**.
* **Configurable Product Support:** Customers can select product options (e.g., size, color) directly within the look
  block.
* **Dynamic Price Calculation:** The total price for the selected items updates in real-time.
* **Smart Stock Handling:** Out-of-stock products are clearly marked and cannot be added to the cart.

## Requirements

* **Magento Open Source / Adobe Commerce:** `2.4.5` or newer
* **PHP:** `~8.1.0 || ~8.2.0 || ~8.3.0`
* **Composer:** `2.x`
* **Elasticsearch / OpenSearch:** Configured for Magento

## Installation

The recommended installation method is via Composer.

1. Install the module using Composer:
   ```bash
   composer require juszczyk/m2-shop-the-look
   ```
2. Enable the module and run the setup process:
   ```bash
   php bin/magento module:enable Juszczyk_ShopTheLook
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento setup:static-content:deploy
   php bin/magento cache:clean
   ```

## Configuration and Usage

1. **Create a Look:**
    * Navigate to `Catalog -> Manage Looks` in the Magento admin panel.
    * Click "Add New Look".
    * Fill in the name, set the status to "Enabled", and use the grid to add the products that will make up the look.
    * Save the look.

2. **Assign the Look to a Product:**
    * Go to the edit page of the product you want to feature as the "main product" for the look (`Catalog -> Products`).
    * Find the new "Shop the Look" tab.
    * Select the look(s) you want to display on this product's page from the list.
    * Save the product.

3. **Verify on the Frontend:**
    * Clear the Magento cache.
    * Navigate to the main product's page on the storefront. The "Shop the Look" block should now be visible.

## Roadmap

While this module is fully functional, here are some ideas for future enhancements:

* [ ] Full GraphQL support (for querying looks and adding to cart).
* [ ] Hyvä Themes compatibility.
* [ ] Advanced caching options for the look block to optimize performance.
* [ ] Drag & drop sorting for products within a look.
* [ ] Analytics dashboard (e.g., tracking views and conversions per look).

## Contributing

Contributions are welcome! Please feel free to submit a pull request or create an issue for any bugs or feature
requests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

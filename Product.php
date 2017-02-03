<?php
/**
 * Created by PhpStorm.
 * User: Yarmaliuk Mikhail
 * Date: 27.01.2017
 * Time: 16:03
 */

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;
use flydreamers\shipwire\exceptions\ShipwireConnectionException;

/**
 * Class        Product
 * @package     flydreamers\shipwire
 * @author      Yarmaliuk Mikhail (Matthew P.)
 * @version     1.0
 */
class Product extends ShipwireComponent
{
    /**
     * Creates an product.
     *
     * @param array $productData
     * @param array $params
     * @return array|bool
     */
    public function create($productData, $params = [])
    {
        return $this->post('products', $params, json_encode($productData));
    }

    /**
     * Update product details.
     *
     * @param string $productID
     * @param $productData
     * @param array $params
     * @return array|bool
     */
    public function update($productID, $productData, $params = [])
    {
        try {
            return $this->put($this->getRoute('products/{id}', $productID), $params, json_encode($productData));
        } catch (ShipwireConnectionException $exception) {
            return ['code' => $exception->getCode(), 'error' => $exception->getMessage()];
        }
    }

    /**
     * List shipwire categories
     *
     * @return array
     */
    public static function getCategories()
    {
        return [
            'APPAREL'                   => 'Apparel, Shoes & Jewelry',
            'AUTOMOTIVE'                => 'Auto Parts & Accessories',
            'BOOKS_&_ENTERTAINMENT'     => 'Books, Movies & Music',
            'COMPUTER_ELECTRONICS'      => 'Computers & Electronics',
            'FOOD_&_BEVERAGE'           => 'Food & Beverage',
            'FURNITURE_&_APPLIANCES'    => 'Furniture & Appliances',
            'HEALTH_&_PERSONAL_CARE'    => 'Health & Personal Care',
            'HOME_&_GARDEN'             => 'Home & Garden',
            'TOYS_SPORTS_HOBBIES'       => 'Toys, Sports & Hobbies',
            'OTHER'                     => 'Other'
        ];
    }
}
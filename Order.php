<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

/**
 * Class Order
 * @package flydreamers\shipwire
 * @author Sebastian Thierer <sebas@flydreamers.com>
 */
class Order extends ShipwireComponent
{
    /**
     * Lists all orders depending on your parameters.
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listing($params = [], $page = 0, $limit = 50)
    {
        return $this->get('orders', $params, $page, $limit);
    }

    /**
     * Gets order details
     * @param $orderId
     * @param bool $expand
     * @param bool $byExternalId Get order by externalId
     * @return array
     */
    public function orderDetails($orderId, $expand = false, $byExternalId = false)
    {
        $route = $this->getRoute('orders/'. ($byExternalId ? 'E' : null) .'{id}', $orderId);

        $params = [];
        if ($expand) {
            $params['expand'] = 'all';
        }
        return $this->get($route, $params);
    }

    /**
     * Cancels an Order
     * @param $orderId
     * @param bool $byExternalId Cancel order by externalId
     * @return bool
     */
    public function cancel($orderId, $byExternalId = false)
    {
        $route = $this->getRoute('orders/'. ($byExternalId ? 'E' : null) .'{id}/cancel', $orderId);

        $ret = $this->post($route, [], null, true);
        return $ret['status'] == 200;
    }

    /**
     * Get the list of holds, if any, on an order
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function holds($orderId, $includeCleared = false, $params = [], $page = 0, $limit = 50)
    {
        if (!isset($params['includeCleared'])) {
            $params['includeCleared'] = $includeCleared ? 1 : 0;
        }
        return $this->get($this->getRoute('orders/{id}/holds', $orderId), $params, $page, $limit);
    }


    /**
     * Get the product details for this order
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function items($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('orders/{id}/items', $orderId), $params, $page, $limit);
    }


    /**
     * Get related return information for a specific order.
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function returns($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('orders/{id}/returns', $orderId), $params, $page, $limit);
    }


    /**
     * Get tracking information for a specific order.
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function tracking($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('orders/{id}/trackings', $orderId), $params, $page, $limit);
    }

    /**
     * Creates an order.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function create($orderData, $params = [])
    {
        return $this->post('orders', $params, json_encode($orderData));
    }

    /**
     * Modify order details.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function update($orderId, $orderData, $params = [])
    {
        return $this->put($this->getRoute('orders/{id}', $orderId), $params, json_encode($orderData));
    }

    /**
     * Errors related to validation errors
     * @var array
     */
    public $errors=[];
}

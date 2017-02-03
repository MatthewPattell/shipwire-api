<?php

namespace flydreamers\shipwire\base;

use flydreamers\shipwire\ShipwireConnector;


/**
 * Class ShipwireComponent
 *
 * @package flydreamers\shipwire\base
 * @author Sebastian Thierer <sebas@flydreamers.com>
 * @version
 *
 */
class ShipwireComponent
{
    /**
     * @var ShipwireConnector
     */
    protected $_connector;

    /**
     * Sets internal settings
     */
    public function __construct()
    {
        $this->_connector = ShipwireConnector::getInstance();
    }

    /**
     * @param string $route
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function get($route, $params, $page=0, $limit=50){
        if ($page!=false){
            $limit = max(1,min($limit,100));
            $page = max(0,$page);
            $params['offset'] = $page * $limit;
            $params['limit'] = $limit;
        }
        return $this->_connector->api($route, $params, ShipwireConnector::GET, null, true);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $body
     * @param bool $onlyResource
     * @return array
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function post($route, $params, $body, $onlyResource=true){
        return $this->_connector->api($route, $params, ShipwireConnector::POST, $body, $onlyResource);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $body
     * @param bool $onlyResource
     * @return array
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function put($route, $params, $body, $onlyResource=true){
        return $this->_connector->api($route, $params, ShipwireConnector::PUT, $body, $onlyResource);
    }

    /**
     * Transform the route with the given orderId
     *
     * @param string $route
     * @param null|string|int $Id
     * @return string
     */
    protected function getRoute($route, $Id = null)
    {
        if ($Id !== null) {
            return strtr($route, ['{id}' => $Id]);
        }

        return $route;
    }

}

<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

/**
 * Class        Address
 * @package     flydreamers\shipwire
 * @version     1.0
 */
class Address extends ShipwireComponent
{
    public $email='';
    public $name='';
    public $phone='';
    public $address1='';
    public $address2='';
    public $address3='';
    public $city='';
    public $postalCode='';
    public $region='';
    public $country='';
    public $isCommercial=0;
    public $isPoBox=0;

    /**
     * Validating api version
     */
    const VERSION_3_1   = 'v3.1';

    /**
     * Serialize this info as array
     * @return array
     */
    public function asArray()
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'address3' => $this->address3,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'region' => $this->region,
            'country' => $this->country,
            'isCommercial' => $this->isCommercial,
            'isPoBox' => $this->isPoBox,
        ];
    }

    /**
     * Serialize this info as json
     * @return string
     */
    public function asJson(){
        return json_encode($this->asArray());
    }

    /**
     * Creates an address from an array
     * @param $arr
     * @return Address
     */
    public static function createFromArray($arr)
    {
        $ret = new Address();
        foreach ($arr as $key => $value) {
            if (property_exists($ret, $key)){
                $ret->$key = $value;
            }
        }
        return $ret;
    }

    /**
     * Validate current address
     *
     * @param array $params
     * @return array|bool
     */
    public function validate($params = [])
    {
        ShipwireConnector::$version = self::VERSION_3_1;

        return $this->post('addressValidation', $params, $this->asJson());
    }
}
<?php

namespace WebPay\Data;

use WebPay\AbstractData;

class EventData extends AbstractData
{

    public function __construct(array $params)
    {
        $this->fields = array('object', 'previous_attributes');
        $params = $this->normalize($this->fields, $params);
        if (!is_array($params['object']) || !array_key_exists('object', $params['object'])) {
    $params['object'] = $params['object'];
} else {
    switch ($params['object']['object']) {
        case 'account':
            $params['object'] = new AccountResponse($params['object']);
            break;
        case 'charge':
            $params['object'] = new ChargeResponse($params['object']);
            break;
        case 'customer':
            $params['object'] = new CustomerResponse($params['object']);
            break;
        case 'recursion':
            $params['object'] = new RecursionResponse($params['object']);
            break;
        case 'shop':
            $params['object'] = new ShopResponse($params['object']);
            break;
        default:
            $params['object'] = $params['object'];
            break;
    }
};
        $this->attributes = $params;
    }

    public function __set($key, $value)
    {
        throw new \Exception('This class is immutable');
    }

}

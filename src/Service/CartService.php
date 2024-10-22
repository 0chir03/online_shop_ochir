<?php

namespace Service;

use Model\UserProduct;

class CartService
{

    private UserProduct $userProduct;


    public function __construct()
    {
        $this->userProduct = new UserProduct();
    }

    public function add(int $userId, int $productId, int $amount)
    {
        $result = $this->userProduct->getByUserIdAndProductId($userId, $productId);
        if ($result === null) {
            $this->userProduct->insert($userId, $productId, $amount);
        } else {
            $this->userProduct->updateAmount($userId, $productId, $amount);
        }
    }
}
<?php

namespace Service;

use DTO\CreateAddProductDTO;
use Model\UserProduct;

class AddProductService
{

    private UserProduct $userProduct;


    public function __construct()
    {
        $this->userProduct = new UserProduct();
    }

    public function add(CreateAddProductDTO $addProductDTO)
    {
        $result = $this->userProduct->getByUserIdAndProductId($addProductDTO->getUserId(), $addProductDTO->getProductId());
        if ($result === null) {
            $this->userProduct->insert($addProductDTO->getUserId(), $addProductDTO->getProductId(), $addProductDTO->getAmount());
        } else {
            $this->userProduct->updateAmount($addProductDTO->getUserId(), $addProductDTO->getProductId(), $addProductDTO->getAmount());
        }
    }
}
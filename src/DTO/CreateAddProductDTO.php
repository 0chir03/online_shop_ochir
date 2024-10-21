<?php

namespace DTO;

class CreateAddProductDTO
{
    public function __construct(private int $userId, private int $productId, private int $amount)
    {

    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


}
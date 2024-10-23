<?php

namespace DTO;

class CreateOrderDTO
{
    public function __construct(
        private string $contactName,
        private int $contactPhone,
        private string $address,
        private int $userId,
    )
    {

    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): int
    {
        return $this->contactPhone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
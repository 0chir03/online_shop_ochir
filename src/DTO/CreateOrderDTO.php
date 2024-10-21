<?php

namespace DTO;

class CreateOrderDTO
{
    public function __construct(
        private string $contact_name,
        private int $contact_phone,
        private string $address,
        private int $user_id,
    )
    {

    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getContactPhone(): int
    {
        return $this->contact_phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
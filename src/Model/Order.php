<?php

namespace Model;
class Order extends Model
{
    public function create(string $contact_name, string $contact_phone, mixed $address, int $sum, int $user_id)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO  orders  (contact_name, contact_phone, address, sum, user_id) VALUES (:contact_name, :contact_phone, :address, :sum, :user_id) RETURNING id");
        $stmt->execute(['contact_name' => $contact_name, 'contact_phone' => $contact_phone,  'address' => $address, 'sum' => $sum, 'user_id' => $user_id]);
        $order_id = $stmt->fetch();
        return $order_id['id'];
    }
}
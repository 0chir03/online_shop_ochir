<?php

namespace Service;

use DTO\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private Order $order;
    private Product $product;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;

    public function __construct()
    {
        $this->order = new Order();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
    }

    public function create(CreateOrderDTO $orderDTO)
    {
           $array = $this->product->getByUserId($orderDTO->getUserId());
           $sum = 0;
           foreach ($array as $key) {
               $sum = $sum + $key->getPrice() * $key->getAmount();
           }
           $data = $this->userProduct->getByUserId($orderDTO->getUserId());

           $pdo = Model::getPDO();
           $pdo->beginTransaction();

           try {
                $order_id = $this->order->create($orderDTO->getContactName(),
                                                 $orderDTO->getContactPhone(),
                                                 $orderDTO->getAddress(),
                                                 $sum,
                                                 $orderDTO->getUserId()
                                                );

               foreach ($data as $item) {
                   $product = $item->getProduct();
                   $product_id = $product->getId();
                   $price = $product->getPrice();
                   $amount = $item->getAmount();
                   $total_price = $price * $amount;

                   $this->orderProduct->create($order_id, $product_id, $amount, $total_price);
               }
               $this->userProduct->deleteByUserId($orderDTO->getUserId());
           } catch (\PDOException $exception) {

           $pdo->rollBack();
           throw $exception;
       }
       $pdo->commit();
    }
}
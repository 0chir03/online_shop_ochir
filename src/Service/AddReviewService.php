<?php

namespace Service;

use Model\OrderProduct;
use Model\Review;
use Request\AddReviewRequest;

class AddReviewService
{
    public function add(int $productId, int $userId, AddReviewRequest $request)
    {
        $orderProducts = OrderProduct::getOrderProducts($productId, $userId);
        if (!empty($orderProducts)) {
            foreach ($orderProducts as $item) {
                $product = $item->getProductId();
                if (empty($product)) {
                    echo "Для того, чтобы оставить отзыв, необходимо сделать заказ";
                }
            }
            $comment = $request->getComment();
            $rating = $request->getRating();
            $date = date("Y-m-d");
            Review::create($userId, $productId, $date, $rating, $comment);
            echo "Благодарим за отзыв";
        } else {
            echo "Для того, чтобы оставить отзыв, необходимо приборести наш продукт";
        }
    }
}
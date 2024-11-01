<?php

namespace Service;

use \Model\User;
class GetReviewService
{
    public function get(array $reviews = null)
    {
        if ($reviews !== null) {
            foreach ($reviews as $item) {
                $userId = $item->getUserId();
                $name = User::getById($userId)->getName();
                echo $item->getDate() . " " . $name . "<br/>" . $item->getComment() . "<br/>" . "<br/>";
            }
        } else {
            echo "Пока нет отзывов";
        }
    }
}
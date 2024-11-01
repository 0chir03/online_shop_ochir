<?php

namespace Service;

class RatingService
{
    public function get(array $reviews = null)
    {
        $sum = 0;
        if ($reviews !== null) {
            foreach ($reviews as $item) {
                $sum = $sum + $item->getRating();
            }
            $count = count($reviews);
            $averageRating = $sum/$count;
        } else {
            $averageRating = 0;
        }
        return $averageRating;
    }
}
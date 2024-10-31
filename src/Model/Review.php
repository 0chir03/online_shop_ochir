<?php

namespace Model;


class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private string $date;
    private int $rating;
    private string $comment;


    public static function create(int $userId, int $productId, string $date, int $rating, string $comment)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO  review  (user_id, product_id, date, rating, comment) VALUES (:userId, :productId, :date, :rating, :comment)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'date' => $date,  'rating' => $rating, 'comment' => $comment]);
    }

    public static function getByProdId(int $productId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM review WHERE product_id = :productId");
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetchAll();

        if (empty($data)) {
            return null;
        }
        $array = [];
        foreach ($data as $item) {
            $obj = new self();
            $obj->id = $item['id'];
            $obj->userId = $item['user_id'];
            $obj->productId = $item['product_id'];
            $obj->date = $item['date'];
            $obj->rating = $item['rating'];
            $obj->comment = $item['comment'];
            $array[] = $obj;
        }
        return $array;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getRating(): string
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

}
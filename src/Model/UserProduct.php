<?php

namespace Model;
class UserProduct extends Model
{

    private int $id;
    private User $user;
    private Product $product;
    private int $amount;

    public static function getByUserIdAndProductId(int $userId, int $productId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $data = $stmt->fetchAll();

        if (empty($data)) {
            return null;
        }
        return self::hydrate($data);
    }

    public static function insert(int $userId, int $productId, int $amount)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function updateAmount($userId, $productId, $amount,)
    {
        $stmt = self::getPDO()->prepare("UPDATE user_products SET amount = amount + :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public static function getByUserId(int $user_id): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        if (empty($data)) {
            return null;
        }
        return self::hydrate($data);
    }

    public static function deleteByUserId(int $user_id)
    {
        $stmt = self::getPDO()->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }

    private static function hydrate(array $data): array
    {
        $array = [];
        foreach ($data as $item) {
            $obj = new self();
            $obj->id = $item['id'];

            $userId = $item['user_id'];
            $userModel = new User();
            $user = $userModel->getById($userId);
            $obj->user = $user;

            $productId = $item['product_id'];
            $productModel = new Product();
            $product = $productModel->getByProdId($productId);
            $obj->product = $product;

            $obj->amount = $item['amount'];
            $array[] = $obj;
        }
        return $array;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}
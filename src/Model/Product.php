<?php

namespace Model;
class Product extends Model
{

    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image;
    private int $user_id;
    private int $product_id;
    private int $amount;

    public function getProducts(): ?array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $result = $stmt->fetchAll();

        if (empty($result)) {
            return null;
        }
        $array = [];
        foreach ($result as $item) {
            $obj = new self();
            $obj->id = $item['id'];
            $obj->name = $item['name'];
            $obj->description = $item['description'];
            $obj->price = $item['price'];
            $obj->image = $item['image'];
            $array[] = $obj;
        }
        return $array;
    }

    public function getByUserId(int $user_id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        if (empty($data)) {
            return null;
        }
        $array = [];
        foreach ($data as $item) {
            $obj = new self();
            $obj->id = $item['id'];
            $obj->name = $item['name'];
            $obj->price = $item['price'];
            $obj->image = $item['image'];
            $obj->user_id = $item['user_id'];
            $obj->product_id = $item['product_id'];
            $obj->amount = $item['amount'];
            $array[] = $obj;
        }
        return $array;
    }

    public function getByProductId(int $product_id): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT price FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }
        $obj = new self();
        $obj->price = $data['price'];

        return $obj;
    }

    public function getByProdId(int $productId): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }
        return $this->hydrate($data);
    }

    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->description = $data['description'];
        $obj->price = $data['price'];
        $obj->image = $data['image'];

        return $obj;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}
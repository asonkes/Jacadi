<?php

namespace App\Entity;

use App\Entity\Orders;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrdersDetailsRepository;

#[ORM\Entity(repositoryClass: OrdersDetailsRepository::class)]
class OrdersDetails
{
    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price = null;

    /**
     * Permet d'avoir une nouvelle clé primaire
     *
     * @var Orders|null
     */
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ordersDetails')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Orders $orders = null;

    /**
     * Même chose pour celui-ci
     *
     * @var Products|null
     */
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ordersDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $products = null;

    #[ORM\Column(length: 20)]
    private ?string $size = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProducts(): ?Products
    {
        return $this->products;
    }

    public function setProducts(?Products $products): static
    {
        $this->products = $products;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }
}

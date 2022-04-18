<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CartRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection<Order>
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="cart")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        $this->orders->add($order);

        return $this;
    }
}

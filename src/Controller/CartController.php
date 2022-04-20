<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Service\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private EntityManagerInterface $em;
    private CartSessionStorage $cartSessionStorage;

    public function __construct(
        EntityManagerInterface $entityManager,
        CartSessionStorage $cartSessionStorage
    ) {
        $this->em = $entityManager;
        $this->cartSessionStorage = $cartSessionStorage;
    }

    /**
     * @Route("cart/count", name="cart_count", methods={"GET"})
     */
    public function countAction()
    {
        $cart = $this->cartSessionStorage->getCart();
        if (!$cart) {
            $cart = new Cart();
            $this->em->persist($cart);
            $this->em->flush();
            $this->cartSessionStorage->setCart($cart);
        }

        return new JsonResponse(['count' => $cart->getOrders()->count()]);
    }
}

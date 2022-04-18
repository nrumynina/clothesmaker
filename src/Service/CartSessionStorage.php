<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage
{
    private const CART_KEY_NAME = 'cart_id';

    public function __construct(
        private CartRepository $cartRepository,
        private RequestStack $requestStack
    ) {}

    public function setCart(Cart $cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart->getId());
    }

    public function getCart(): ?Cart
    {
        return $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
        ]);
    }

    private function getCartId(): ?int
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}

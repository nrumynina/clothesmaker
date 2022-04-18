<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Model;
use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Service\CartSessionStorage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $em;
    private CartSessionStorage $cartSessionStorage;

    public function __construct(
        ManagerRegistry $doctrine,
        CartSessionStorage $cartSessionStorage
    ) {
        $this->em = $doctrine->getManager();
        $this->cartSessionStorage = $cartSessionStorage;
    }

    /**
     * @Route("order/create", name="order_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $modelId = $request->get('order')['model'];
        /** @var Model|null $model */
        $model = $this->em->getRepository(Model::class)->find($modelId);

        if (!$model) {
            return new JsonResponse(['success' => false]);
        }

        $order = (new Order())
            ->setModel($model);
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $this->cartSessionStorage->getCart();
            if (!$cart) {
                $cart = new Cart();
                $this->em->persist($cart);
                $this->cartSessionStorage->setCart($cart);
            }

            $order->setCart($cart);

            $this->em->persist($order);
            $this->em->flush();

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false]);
    }
}

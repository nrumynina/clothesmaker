<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Model;
use App\Entity\Order;
use App\Form\Type\OrderType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CartController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    /**
     * @Route("order/create/{model_id}", name="order_create", methods={"GET", "POST"})
     *
     * @ParamConverter("model", options={"mapping": {"model_id": "id"}})
     */
    public function addToCartAction(Model $model, Request $request)
    {
        $order = (new Order())
            ->setModel($model);
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {




            $this->em->persist($order);
            $this->em->flush();

            return $this->redirectToRoute('cloth_create');
        }

        return $this->renderForm('cart/order.html.twig', [
            'form' => $form,
            'model' => $model,
        ]);
    }
}

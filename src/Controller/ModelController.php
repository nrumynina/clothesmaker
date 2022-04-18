<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Model;
use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Security\ModelVoter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModelController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    /**
     * @Route("/", name="model_index", methods={"GET"})
     */
    public function indexAction()
    {
        $repository = $this->em->getRepository(Model::class);

        /** @var Model[] $model */
        $model = $repository->findAll();

        return $this->render('model/index.html.twig', [
            'modelList' => $model
        ]);
    }

    /**
     * @Route("/show/{id}", name="model_show", methods={"GET"})
     */
    public function showAction(Model $model)
    {
//        $this->denyAccessUnlessGranted(ModelVoter::SHOW, $model);

        $order = (new Order())
            ->setModel($model);
        $form = $this->createForm(OrderType::class, $order);

        return $this->renderForm('model/show.html.twig', [
            'model' => $model,
            'order' => $order,
            'order_form' => $form,
        ]);
    }
}

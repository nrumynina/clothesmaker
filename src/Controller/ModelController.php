<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Model;
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
        return $this->render('model/show.html.twig', [
            'model' => $model
        ]);
    }
}

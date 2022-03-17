<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Model;
use App\Form\Type\ModelType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModelController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    /**
     * @Route("/model/create", name="model_create")
     */
    public function createAction(Request $request)
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $this->em->persist($model);
            $this->em->flush();

            return $this->redirectToRoute('model_create');
        }

        return $this->renderForm('model/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/model/list", name="model_list")
     */
    public function listAction()
    {
        $repository = $this->em->getRepository(Model::class);

        /** @var Model[] $models */
        $models = $repository->findAll();

        return $this->render('model/list.html.twig', [
            'modelList' => $models
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Cloth;
use App\Form\Type\ClothType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClothController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    /**
     * @Route("/cloth/create", name="cloth_create")
     */
    public function createAction(Request $request)
    {
        $cloth = new Cloth();
        $form = $this->createForm(ClothType::class, $cloth);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $this->em->persist($cloth);
            $this->em->flush();

            return $this->redirectToRoute('cloth_create');
        }

        return $this->renderForm('cloth/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/cloth/list", name="cloth_list")
     */
    public function listAction()
    {
        $repository = $this->em->getRepository(Cloth::class);

        /** @var Cloth[] $clothes */
        $clothes = $repository->findAll();

        $params = [
            'clothList' => $clothes
        ];

        return $this->render('cloth/list.html.twig', $params);

    }
}

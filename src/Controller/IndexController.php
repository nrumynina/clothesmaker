<?php

namespace App\Controller;

use App\Entity\Cloth;
use App\Entity\Model;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $entityManager = $this->doctrine->getManager();

//        $cloth = new Cloth();
//        $cloth->setName('len');
//        $cloth->setColor('red');
//
//        $entityManager->persist($cloth);
//        $entityManager->flush();

        $repository = $entityManager->getRepository(Cloth::class);

        /** @var Cloth[] $clothes */
        $clothes = $repository->findAll();

        $params = [
            'clothList' => $clothes
        ];

        return $this->render('index/index.html.twig', $params);
    }

    /**
     * @Route("/show", name="show")
     */
    public function showAction()
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository(Model::class);

        /** @var Model[] $model */
        $model = $repository->findAll();

        $params = [
            'modelList' => $model
        ];

        return $this->render('index/show.html.twig');
    }
}

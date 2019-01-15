<?php

namespace App\Controller;

use App\Entity\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        // Instancy repository and get all collections
        $repository = $this->getDoctrine()->getRepository(Collection::class);
        $collections = $repository->findAll();

        return $this->render('index/index.html.twig', [
            'collections' => $collections
        ]);
    }

    /**
     * @Route("/empty", name="empty")
     */
    public function empty()
    {
        return $this->render('empty.html.twig');
    }
}

<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Entity\Product;
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
        $repositoryCollection = $this->getDoctrine()->getRepository(Collection::class);
        $collections = $repositoryCollection->findBy([], [
            'dateAdd' => 'DESC'
        ], 2);
        // Instancy repository and get all products
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $products = $repositoryProduct->findBy([], [
            'dateAdd' => 'DESC'
        ], 8);

        return $this->render('index/index.html.twig', [
            'collections' => $collections,
            'products' => $products
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

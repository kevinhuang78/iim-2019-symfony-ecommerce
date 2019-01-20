<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    /**
     * @param $slug
     * @Route("/collection/{slug}", name="collection", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($slug)
    {
        // Instancy repository and get all products
        $repositoryCollection = $this->getDoctrine()->getRepository(Collection::class);
        $collection = $repositoryCollection->findOneBy([
            'slug' => $slug
        ]);
        // TODO: Use getProducts() method to get them and not findBy Collection (don't forget view too)
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $products = $repositoryProduct->findBy(
            ['collection' => $collection]
        );

        if (!$collection instanceof Collection) {
            throw new NotFoundHttpException('Collection not found');
        }

        return $this->render('collection/index.html.twig', [
            'collection' => $collection,
            'products' => $products
        ]);
    }

    /**
     * @Route("/collections", name="collections", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCollections()
    {
        // Instancy repository and get all products
        $repositoryCollection = $this->getDoctrine()->getRepository(Collection::class);
        $collections = $repositoryCollection->findAll();

        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $products = $repositoryProduct->findAll();
        // TODO: Use getProducts() method to get them and not findBy Collection (don't forget view too)
        dd($collections[0]);

        return $this->render('collection/collections.html.twig', [
            'collections' => $collections,
            'products' => $products
        ]);
    }
}

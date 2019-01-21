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
        $repositoryCollection = $this->getDoctrine()->getRepository(Collection::class);
        $collection = $repositoryCollection->findOneBy([
            'slug' => $slug
        ]);

        if (!$collection instanceof Collection) {
            throw new NotFoundHttpException('Collection not found');
        }

        return $this->render('collection/index.html.twig', [
            'collection' => $collection
        ]);
    }

    /**
     * @param $offset
     * @Route("/collections/{offset}", name="collections", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCollections($offset)
    {
        $limit = 2;
        $repositoryCollection = $this->getDoctrine()->getRepository(Collection::class);
        $numberCollections = count($repositoryCollection->findAll());
        $numberPages = ceil($numberCollections / $limit);
        $collections = $repositoryCollection->findBy([], null, $limit, ( $limit * ( $offset - 1 ) ));

        return $this->render('collection/collections.html.twig', [
            'collections' => $collections,
            'maxPagination' => $numberPages
        ]);
    }
}

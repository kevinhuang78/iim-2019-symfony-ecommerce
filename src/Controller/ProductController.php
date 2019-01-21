<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @param $slug
     * @Route("/product/{slug}", name="product", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($slug)
    {
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $product = $repositoryProduct->findOneBy([
            'slug' => $slug
        ]);

        if (!$product instanceof Product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $this->render('product/index.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @param $offset
     * @Route("/products/{offset}", name="products", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allProducts($offset)
    {
        $limit = 10;
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $numberProducts = count($repositoryProduct->findAll());
        $numberPages = ceil($numberProducts / $limit);
        $products = $repositoryProduct->findBy([], null, $limit, ( $limit * ( $offset - 1 ) ));

        return $this->render('product/products.html.twig', [
            'products' => $products,
            'maxPagination' => $numberPages
        ]);
    }
}

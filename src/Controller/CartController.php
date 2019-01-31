<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @param SessionInterface $session
     * @Route("/cart", name="cart", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session)
    {
        $cartId = $session->get('cart');
        $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
        $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * @param SessionInterface $session
     * @Route("/cart.json", name="cart_json", methods={"GET"})
     * @return JsonResponse
     */
    public function cartJson(SessionInterface $session)
    {
        $cartId = $session->get('cart');
        $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
        $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();

        $lastProductAdded = $cart->getCartProducts()[count($cart->getCartProducts()) - 1]
            ? $cart->getCartProducts()[count($cart->getCartProducts()) - 1]->getProduct()
            : new Cart();

        return new JsonResponse([
            'lastProductAdded' => [
                'name'       => $lastProductAdded->getName(),
                'price'      => $lastProductAdded->getPrice(),
                'pictureUrl' => $lastProductAdded->getPictureUrl()
            ],
            'newTotalProducts' => count($cart->getCartProducts()),
            'newTotal' => $cart->getTotal()
        ]);
    }

    /**
     * @param SessionInterface $session
     * @Route("/cart_reset", name="cart_reset", methods={"GET"})
     * @return JsonResponse
     */
    public function cartReset(SessionInterface $session)
    {
        $session->set('cart', null);

        return new JsonResponse([
            'status' => 'done'
        ]);
    }

    /**
     * @param Request $request
     * @param SessionInterface $session
     * @Route("/cart/add.json", name="add_cart_json", methods={"POST"})
     * @return JsonResponse
     */
    public function addToCartJson(Request $request, SessionInterface $session)
    {
        // Instancy repository and get all products
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $product = $repositoryProduct->find($request->request->get('product_id'));

        $objectManager = $this->getDoctrine()->getManager();

        if (!$product instanceof Product) {
            $status = "KO";
            $message = "Product not found";
        } else {
            if ($product->getStock() < $request->request->get('quantity')) {
                $status = "KO";
                $message = "Missing quantity for product";
            } else {
                $cartId = $session->get('cart');
                if (!$cartId) {
                    $cart = new Cart();
                    $objectManager->persist($cart);
                    $objectManager->flush();
                    $session->set('cart', $cartId = $cart->getId());
                } else {
                    $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
                    /** @var Cart $cart */
                    $cart = $repositoryCart->find($cartId);
                }
                $cartProduct = new CartProduct();
                $cartProduct->setCart($cart);
                $cartProduct->setProduct($product);
                $cartProduct->setQuantity((int) $request->request->get('quantity'));

                $objectManager->persist($cartProduct);
                $objectManager->flush();

                $status = "OK";
                $message = "Added to cart";
            }
        }

        return new JsonResponse([
            'result'  => $status,
            'message' => $message
        ]);
    }

    public function partial(SessionInterface $session)
    {
        $cartId = $session->get('cart');
        $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
        $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();

        return $this->render('partials/cart.html.twig', [
            'cart' => $cart
        ]);
    }
}

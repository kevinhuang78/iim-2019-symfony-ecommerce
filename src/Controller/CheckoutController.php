<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\OrderCommand;
use App\Form\CardType;
use App\Model\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/checkout")
 */
class CheckoutController extends AbstractController
{
    /**
     * @param Request $request
     * @param SessionInterface $session
     * @Route("/payment", name="checkout_payment", methods={"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function payment(Request $request, SessionInterface $session)
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartId = $session->get('cart');
            $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
            $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();
            $user = $this->getUser();

            $order = new OrderCommand();
            $order->setUser($user);
            $order->setCart($cart);
            $order->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            $session->set('cart', null);
            $cart = new Cart();

            return $this->render('cart/index.html.twig', [
                'cart'   => $cart,
                'status' => 'done'
            ]);
        }

        return $this->render('checkout/payment.html.twig', [
            'card' => $card,
            'form' => $form->createView(),
        ]);
    }
}

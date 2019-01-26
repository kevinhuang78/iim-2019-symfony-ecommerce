<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\OrderCommand;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{

    /**
     * @param UserInterface $user
     * @param Request $request
     * @Route("/user/profile", name="user_profile", methods={"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userProfile(UserInterface $user, Request $request)
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();
        }

        $repositoryAddress = $this->getDoctrine()->getRepository(Address::class);
        $userAddresses = $repositoryAddress->findBy([
            'user' => $user
        ]);

        $repositoryOrder = $this->getDoctrine()->getRepository(OrderCommand::class);
        $userOrders = $repositoryOrder->findBy([
            'user' => $user
        ], ['createdAt' => 'DESC']);

        return $this->render('user/profile.html.twig', [
            'user'        => $user,
            'form'        => $form->createView(),
            'myAddresses' => $userAddresses,
            'orders'      => $userOrders
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\OrderCommand;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{

    /**
     * @param UserInterface $user
     * @param Request $request
     * @Route("/user/profile", name="user_profile", methods={"GET", "POST"})
     * @Route("/admin/data", name="admin_data", methods={"GET", "POST"})
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

    /**
     * @param Request $request
     * @param Address $address
     * @param $id
     * @Route("/user/profile/{id}/edit", name="user_profile_edit", methods={"GET", "POST"})
     * @Route("/admin/data/{id}/edit", name="admin_data_edit", methods={"GET", "POST"})
     * @return Response
     */
    public function editAddress(Request $request, Address $address, $id): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/editAddress.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param UserInterface $user
     * @Route("/admin/profile", name="admin_profile", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminProfile(UserInterface $user)
    {
        return $this->render('admin/profile/index.html.twig', [
            'user' => $user
        ]);
    }
}

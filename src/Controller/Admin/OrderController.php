<?php

namespace App\Controller\Admin;

use App\Entity\OrderCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/orders")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/list", name="orders_list", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orderList()
    {
        $repositoryOrder = $this->getDoctrine()->getRepository(OrderCommand::class);
        $userOrders = $repositoryOrder->findBy([], ['createdAt' => 'DESC']); // Find All with filter

        return $this->render('admin/orderCommands/list.html.twig', [
            'orders'  => $userOrders
        ]);
    }

    /**
     * @param $id
     * @Route("/{id}", name="order_show", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orderShow($id)
    {
        $repositoryOrder = $this->getDoctrine()->getRepository(OrderCommand::class);
        $order = $repositoryOrder->findOneBy(['id' => $id]);

        return $this->render('admin/orderCommands/show.html.twig', [
            'order'  => $order
        ]);
    }
}

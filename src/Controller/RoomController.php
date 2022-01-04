<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as RoomManagerRegistry;

class RoomController extends AbstractController
{
    private $em;
    public function __construct(RoomManagerRegistry $registry)
    {
        $this->em = $registry;
    }
    /**
    * @Route("/room/", name="room_index")
    */
    public function roomIndex() {
        $rooms = $this->em->getRepository(Room::class)->findAll();
        return $this->render("room/index.html.twig",
        [
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/room/delete/{id}" , name="room_delete")
     */
    public function roomDelete($id) {
        $room = $this->em->getRepository(Room::class)->find($id);
        if ($room == null) {
            $this->addFlash("Error", "room delete failed");         
        } else {
            $manager = $this->em->getManager();
            $manager->remove($room);
            $manager->flush();
            $this->addFlash("Success", "room delete succeed");
        }
        return $this->redirectToRoute("room_index");
    }

   /**
     * @Route("/room/add", name="room_add")
     */
    public function roomAdd(Request $request) {
        $room = new Room();
        $form = $this->createForm(RoomType::class,$room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->em->getManager();
            $manager->persist($room);
            $manager->flush();
            $this->addFlash("Success","Add room succeed !");
            return $this->redirectToRoute("room_index");
        }

        return $this->renderForm("room/add.html.twig",
        [
            'form' => $form
        ]);
    }

    /**
     * @Route("/room/edit/{id}", name="room_edit")
     */
    public function roomEdit(Request $request, $id) {
        $room = $this->em->getRepository(Room::class)->find($id);
        $form = $this->createForm(RoomType::class,$room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->em->getManager();
            $manager->persist($room);
            $manager->flush();
            $this->addFlash("Success","Edit room succeed !");
            return $this->redirectToRoute("room_index");
        }

        return $this->renderForm("room/edit.html.twig",
        [
            'form' => $form
        ]);
    }
}


<?php

namespace App\Controller;
use App\Entity\Foro;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $foroPublic = $this->getDoctrine()->getRepository(Foro::class)->findBy(array('type' => 'public'));
        $foroNoPublic = $this->getDoctrine()->getRepository(Foro::class)->findBy(array('type' => 'private'));
        $foro = $this->getDoctrine()->getRepository(Foro::class)->findAll();
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        $userB = $this->getDoctrine()->getRepository(User::class)->findBy(array('visible' => '0'));
        $userNB = $this->getDoctrine()->getRepository(User::class)->findBy(array('visible' => '1'));
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'foro' => $foro,
            'foroPublic' => $foroPublic,
            'foroNoPublic' => $foroNoPublic,
            'user' => $user,
            'userB' => $userB,
            'userNB' => $userNB
        ]);
    }
}

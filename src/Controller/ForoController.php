<?php

namespace App\Controller;

use App\Entity\Foro;
use App\Form\ForoType;
use App\Repository\ForoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/foro")
 */
class ForoController extends AbstractController
{
    /**
     * @Route("/", name="foro_index", methods={"GET"})
     */
    public function index(ForoRepository $foroRepository): Response
    {
        return $this->render('foro/index.html.twig', [
            'foros' => $foroRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="foro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $foro = new Foro();
        $form = $this->createForm(ForoType::class, $foro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($foro);
            $entityManager->flush();

            return $this->redirectToRoute('foro_index');
        }

        return $this->render('foro/new.html.twig', [
            'foro' => $foro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="foro_show", methods={"GET"})
     */
    public function show(Foro $foro): Response
    {
        return $this->render('foro/show.html.twig', [
            'foro' => $foro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="foro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Foro $foro): Response
    {
        $form = $this->createForm(ForoType::class, $foro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('foro_index');
        }

        return $this->render('foro/edit.html.twig', [
            'foro' => $foro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="foro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Foro $foro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$foro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($foro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('foro_index');
    }
}

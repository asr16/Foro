<?php

namespace App\Controller;
use App\Entity\Hilo;
use App\Entity\Comentarios;
use App\Form\ComentariosType;
use App\Repository\ComentariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comentarios")
 */
class ComentariosController extends AbstractController
{
    /**
     * @Route("/", name="comentarios_index", methods={"GET"})
     */
    public function index(ComentariosRepository $comentariosRepository): Response
    {
        return $this->render('comentarios/index.html.twig', [
            'comentarios' => $comentariosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="comentarios_new", methods={"GET","POST"})
     */
    public function new(Request $request, Hilo $id): Response
    {
        $comentario = new Comentarios();
        $fecha = new \DateTime();

        $form = $this->createForm(ComentariosType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comentario->setUser($this->getUser());
            $comentario->setDate($fecha);
            $comentario->setVisible('1');
            $comentario->setHilo($this->getDoctrine()->getRepository(Hilo::class)->find($id));
            $comentario->setHilo($id);
            $entityManager->persist($comentario);
            $entityManager->flush();

            return $this->redirectToRoute('comentarios_index');
        }

        return $this->render('comentarios/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comentarios_show", methods={"GET"})
     */
    public function show(Comentarios $comentario): Response
    {
        return $this->render('comentarios/show.html.twig', [
            'comentario' => $comentario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comentarios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comentarios $comentario): Response
    {
        $form = $this->createForm(ComentariosType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comentarios_index');
        }

        return $this->render('comentarios/edit.html.twig', [
            'comentario' => $comentario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comentarios_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comentarios $comentario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comentario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comentarios_index');
    }
}

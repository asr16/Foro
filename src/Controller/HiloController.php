<?php

namespace App\Controller;
use App\Entity\Foro;
use App\Entity\Hilo;
use App\Form\HiloType;
use App\Repository\HiloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hilo")
 */
class HiloController extends AbstractController
{
    /**
     * @Route("/", name="hilo_index", methods={"GET"})
     */
    public function index(HiloRepository $hiloRepository): Response
    {
        return $this->render('hilo/index.html.twig', [
            'hilos' => $hiloRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="hilo_new", methods={"GET","POST"})
     */
    public function new(Request $request, Foro $id): Response
    {
        $hilo = new Hilo();
        $fecha = new \DateTime();

        $form = $this->createForm(HiloType::class, $hilo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $hilo->setUser($this->getUser());
            $hilo->setDate($fecha);
            $hilo->setVisible('1');
            $hilo->setHiloForo($this->getDoctrine()->getRepository(Foro::class)->find($id));
            $hilo->setHiloForo($id);
            $entityManager->persist($hilo);
            $entityManager->flush();

            return $this->redirectToRoute('hilo_index');
        }

        return $this->render('hilo/new.html.twig', [
            'hilo' => $hilo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hilo_show", methods={"GET"})
     */
    public function show(Hilo $hilo): Response
    {
        return $this->render('hilo/show.html.twig', [
            'hilo' => $hilo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hilo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hilo $hilo): Response
    {
        $form = $this->createForm(HiloType::class, $hilo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hilo_index');
        }

        return $this->render('hilo/edit.html.twig', [
            'hilo' => $hilo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hilo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hilo $hilo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hilo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hilo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hilo_index');
    }
}

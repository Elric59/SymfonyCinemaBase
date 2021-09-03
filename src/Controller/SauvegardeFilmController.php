<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\SauvegardeFilm;
use App\Form\SauvegardeFilmType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SauvegardeFilmController extends AbstractController
{
    /**
     * @Route("saveFilm/{id}/new", name="sauvegardeFilm_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request,Film $film): Response
    {
        $sauvegarde = new SauvegardeFilm();
        $form = $this->createForm(SauvegardeFilmType::class, $sauvegarde,['film'=>$film]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sauvegarde);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sauvegarde_film/new.html.twig', [
            'sauvegarde' => $sauvegarde,
            'form' => $form->createView(),
            'film' => $film
        ]);
    }

    /**
     * @Route("saveFilm/{id}/delete", name="sauvegardeFilm_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, SauvegardeFilm $sauvegardeFilm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sauvegardeFilm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sauvegardeFilm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{

    /**
     * @Route("genre/new", name="genres_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $genres = new Genre();
        $form = $this->createForm(GenreType::class, $genres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genres);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('genre/new.html.twig', [
            'genres' => $genres,
            'form' => $form->createView(),
        ]);
    }


}

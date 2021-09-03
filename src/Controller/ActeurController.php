<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Form\ActeursType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeurController extends AbstractController
{

    /**
     * @Route("/acteur/new", name="acteurs_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * Ajout d'un Acteur
     */
    public function new(Request $request): Response
    {
        $acteurs = new Acteur();
        $form = $this->createForm(ActeursType::class, $acteurs);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($acteurs);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('acteur/new.html.twig', [
            'acteurs' => $acteurs,
            'form' => $form->createView(),
        ]);
    }
}

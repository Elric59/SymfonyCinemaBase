<?php

namespace App\Controller;

use App\Entity\SauvegardeSerie;
use App\Entity\Serie;
use App\Form\SauvegardeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SauvegardeSerieController extends AbstractController
{

    /**
     * @Route("saveSerie/{id}/new", name="sauvegarde_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request,Serie $series): Response
    {
        $sauvegarde = new SauvegardeSerie();
        $form = $this->createForm(SauvegardeType::class, $sauvegarde,['series'=>$series]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sauvegarde);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sauvegarde_serie/new.html.twig', [
            'sauvegarde' => $sauvegarde,
            'form' => $form->createView(),
            'series' => $series
        ]);
    }

    /**
     * @Route("saveSerie/{id}/delete", name="sauvegarde_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, SauvegardeSerie $sauvegardeSerie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sauvegardeSerie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sauvegardeSerie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

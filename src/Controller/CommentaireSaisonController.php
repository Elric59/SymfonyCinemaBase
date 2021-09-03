<?php

namespace App\Controller;

use App\Entity\CommentaireSaison;
use App\Entity\Saison;
use App\Form\CommentSaisonType;
use App\Repository\CommentaireSaisonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class CommentaireSaisonController extends AbstractController
{
    /**
     * @Route("commentaireSaison/mesCommentaires", name="commentsSaison_index", methods={"GET"})
     *
     */
    public function index(CommentaireSaisonRepository $commentsRepository): Response
    {
        $commentaires = $commentsRepository->findCommentSaisonByUser($this->getUser());

        return $this->render('commentaire_saison/index.html.twig', [
            'comments' => $commentaires,
        ]);
    }

    /**
     * @Route("commentaireSaison/{id}/new", name="commentsSaison_new", methods={"GET","POST"})
     *
     */
    public function new(Request $request, Saison $saison): Response
    {
        $comment = new CommentaireSaison();
        $form = $this->createForm(CommentSaisonType::class, $comment, ['saison' => $saison]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('saison_show', ["id" => $saison->getId()]);
        }

        return $this->render('commentaire_saison/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'saison' => $saison
        ]);
    }

    /**
     * @Route("commentaireSaison/{id}/{Episode}/edit", name="commentsSaison_edit", methods={"GET","POST"})
     * @Entity ("saison",expr="repository.find(Saison)")
     *
     *
     */
    public function edit(Request $request, CommentaireSaison $comment, Saison $saison): Response
    {
        //$comment = $commentaireEpisodeRepository->findEpisodeFromUserAndComments($comment,$this->getUser());
        $comment->setSaison($saison);
        $form = $this->createForm(CommentSaisonType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('commentaire_saison/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("commentaireSaison/{id}/delete", name="commentsSaison_delete", methods={"Post"})
     *
     */
    public function delete(Request $request, CommentaireSaison $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

<?php

namespace App\Controller;


use App\Entity\CommentaireEpisode;
use App\Entity\Episode;
use App\Form\CommentEpisodeType;
use App\Repository\CommentaireEpisodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class CommentaireEpisodeController extends AbstractController
{

    /**
     * @Route("commentaireEpisode/mesCommentaires", name="comments_index", methods={"GET"})
     * Page contenant les commentaires de l'utilsateur
     *
     */
    public function index(CommentaireEpisodeRepository $commentsRepository): Response
    {
        $commentaires = $commentsRepository->findCommentEpisodeByUser($this->getUser());

        return $this->render('commentaire_episode/index.html.twig', [
            'comments' => $commentaires,
        ]);
    }

    /**
     * @Route("commentaireEpisode/{id}/new", name="commentsEpisode_new", methods={"GET","POST"})
     * Ajouter un commentaire pour l'épisode
     */
    public function new(Request $request, Episode $episode): Response
    {
        $comment = new CommentaireEpisode();
        $form = $this->createForm(CommentEpisodeType::class, $comment, ['episode' => $episode]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('episode_show', ["id" => $episode->getId()]);
        }

        return $this->render('commentaire_episode/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'episode' => $episode
        ]);
    }

    /**
     * @Route("commentaireEpisode/{id}/{Episode}/edit", name="comments_edit", methods={"GET","POST"})
     * @Entity ("episode",expr="repository.find(Episode)")
     * Editer un commentaire
     *
     */
    public function edit(Request $request, CommentaireEpisode $comment, Episode $episode): Response
    {
        //$comment = $commentaireEpisodeRepository->findEpisodeFromUserAndComments($comment,$this->getUser());
        $comment->setEpisode($episode);
        $form = $this->createForm(CommentEpisodeType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('commentaire_episode/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("commentaireEpisode/{id}/delete", name="comments_delete", methods={"Post"})
     * Supprimer le commentaire
     */
    public function delete(Request $request, CommentaireEpisode $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

}

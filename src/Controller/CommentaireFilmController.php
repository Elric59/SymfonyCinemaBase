<?php

namespace App\Controller;

use App\Entity\CommentaireFilm;
use App\Entity\Film;
use App\Form\CommentFilmType;
use App\Repository\CommentaireFilmRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class CommentaireFilmController extends AbstractController
{
    /**
     * @Route("commentaireFilm/mesCommentaires", name="commentsFilm_index", methods={"GET"})
     *
     */
    public function index(CommentaireFilmRepository $commentsRepository): Response
    {
        $commentaires = $commentsRepository->findCommentFilmByUser($this->getUser());

        return $this->render('commentaire_film/index.html.twig', [
            'comments' => $commentaires,
        ]);
    }

    /**
     * @Route("commentaireFilm/{id}/new", name="commentsFilm_new", methods={"GET","POST"})
     *
     */
    public function new(Request $request, Film $film): Response
    {
        $comment = new CommentaireFilm();
        $form = $this->createForm(CommentFilmType::class, $comment, ['film' => $film]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('film_show', ["id" => $film->getId()]);
        }

        return $this->render('commentaire_film/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'film' => $film
        ]);
    }

    /**
     * @Route("commentaireFilm/{id}/{Episode}/edit", name="commentsFilm_edit", methods={"GET","POST"})
     * @Entity ("film",expr="repository.find(Film)")
     *
     *
     */
    public function edit(Request $request, CommentaireFilm $comment, Film $film): Response
    {
        //$comment = $commentaireEpisodeRepository->findEpisodeFromUserAndComments($comment,$this->getUser());
        $comment->setFilm($film);
        $form = $this->createForm(CommentFilmType::class, $comment);
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
     * @Route("commentaireFilm/{id}/delete", name="commentsFilm_delete", methods={"Post"})
     *
     */
    public function delete(Request $request, CommentaireFilm $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

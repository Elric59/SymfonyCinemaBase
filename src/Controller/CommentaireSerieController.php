<?php

namespace App\Controller;

use App\Entity\CommentaireSerie;
use App\Entity\Serie;
use App\Form\CommentSerieType;
use App\Repository\CommentaireSerieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class CommentaireSerieController extends AbstractController
{
    /**
     * @Route("commentaireSerie/mesCommentaires", name="commentsSerie_index", methods={"GET"})
     *
     */
    public function index(CommentaireSerieRepository $commentsRepository): Response
    {
        $commentaires = $commentsRepository->findCommentFilmByUser($this->getUser());

        return $this->render('commentaire_serie/index.html.twig', [
            'comments' => $commentaires,
        ]);
    }

    /**
     * @Route("commentaireSerie/{id}/new", name="commentsSerie_new", methods={"GET","POST"})
     *
     */
    public function new(Request $request, Serie $serie): Response
    {
        $comment = new CommentaireSerie();
        $form = $this->createForm(CommentSerieType::class, $comment, ['serie' => $serie]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('series_show', ["id" => $serie->getId()]);
        }

        return $this->render('commentaire_serie/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'serie' => $serie
        ]);
    }

    /**
     * @Route("commentaireSerie/{id}/{Episode}/edit", name="commentsSerie_edit", methods={"GET","POST"})
     * @Entity ("serie",expr="repository.find(Serie)")
     *
     *
     */
    public function edit(Request $request, CommentaireSerie $comment, Serie $serie): Response
    {
        //$comment = $commentaireEpisodeRepository->findEpisodeFromUserAndComments($comment,$this->getUser());
        $comment->setSerie($serie);
        $form = $this->createForm(CommentSerieType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('commentaire_serie/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("commentaireSerie/{id}/delete", name="commentsSerie_delete", methods={"Post"})
     *
     */
    public function delete(Request $request, CommentaireSerie $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

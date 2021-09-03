<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UserType;
use App\Repository\CommentaireEpisodeRepository;
use App\Repository\CommentaireFilmRepository;
use App\Repository\CommentaireSaisonRepository;
use App\Repository\CommentaireSerieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("user/{id}/profil", name="user_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(CommentaireEpisodeRepository $commentsRepository,CommentaireFilmRepository $commentaireFilmRepository,
                         CommentaireSaisonRepository $commentaireSaisonRepository,CommentaireSerieRepository $commentaireSerieRepository ,
                         Utilisateur $user): Response
    {
        $commentEpisode = $commentsRepository->findBy(['User'=>$user]);
        $commentSerie = $commentaireSerieRepository->findBy(['User'=>$user]);
        $commentSaison = $commentaireSaisonRepository->findBy(['User'=>$user]);
        $commentFilm = $commentaireFilmRepository->findBy(['User'=>$user]);

        $totalComments = count($commentEpisode) + count($commentSerie)+count($commentSaison)+count($commentFilm);
        $ListComments = array_merge($commentSerie,$commentEpisode,$commentSaison,$commentFilm);

        return $this->render('utilisateur/show.html.twig', [
            'user' => $user,
            'listComments' => $ListComments,
            'commentsTotal'=>$totalComments
        ]);
    }

    /**
     * @Route("user/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Utilisateur $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        //test ajout avatar

        $file = $form['avatar']->getData();

        if ($file !== null && $file instanceof UploadedFile) {

            $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            try {
                $fileName = \uniqid() . \urldecode($fileInfo) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('user_path'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Error on FileUpload : ' . $e->getMessage());

                return $this->redirectToRoute('home');
            }
            $user->setAvatar($fileName);
        }
        //test ajout avatar


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/{id}/delete", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Utilisateur $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

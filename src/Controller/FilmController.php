<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Form\MoviesType;
use App\Repository\CommentaireFilmRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("film/{id}/show", name="film_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Film $film,CommentaireFilmRepository $commentaireFilmRepository): Response
    {
        $commentaires = $commentaireFilmRepository->findCommentFilmByUser($this->getUser());

        return $this->render('film/show.html.twig', [
            'film' => $film,
            'comments'=>$commentaires
        ]);
    }

    /**
     * @Route("film/new", name="films_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $films = new Film();
        $form = $this->createForm(MoviesType::class, $films);
        $form->handleRequest($request);

        $file = $form['image']->getData();

        if($file instanceof UploadedFile) {

            $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            try {
                $fileName = \uniqid() . \urldecode($fileInfo) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('film_image'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Error on FileUpload : ' . $e->getMessage());

                return $this->redirectToRoute('home');
            }
            $films->setImage($fileName);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($films);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('film/new.html.twig', [
            'films' => $films,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("film/{id}/edit", name="film_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Film $film): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('film_show',['id'=>$film->getId()]);
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("film/{id}/delete", name="film_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Film $film): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}

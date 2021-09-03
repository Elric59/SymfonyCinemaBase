<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Form\EpisodesType;
use App\Repository\CommentaireEpisodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{


    /**
     * @Route("episode/{id}/show", name="episode_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Episode $episode,CommentaireEpisodeRepository $commentaireEpisodeRepository): Response
    {
        $comments = $commentaireEpisodeRepository->findBy(['Episode'=>$episode]);


        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
            'comments'=>$comments
        ]);
    }

    /**
     * @Route("episode/new", name="episodes_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodesType::class, $episode);
        $form->handleRequest($request);

        $file = $form['image']->getData();

        if($file instanceof UploadedFile) {

            $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            try {
                $fileName = \uniqid() . \urldecode($fileInfo) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('episode_image'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Error on FileUpload : ' . $e->getMessage());

                return $this->redirectToRoute('home');
            }
            $episode->setImage($fileName);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($episode);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('episode/new.html.twig', [
            'episodes' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("episode/{id}/edit", name="episode_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Episode $episode): Response
    {
        $form = $this->createForm(EpisodesType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('episode_show',['id'=>$episode->getId()]);
        }

        return $this->render('episode/edit.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("episode/{id}/delete", name="episode_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }


}

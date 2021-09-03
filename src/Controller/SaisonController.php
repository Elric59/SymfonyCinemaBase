<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Form\SaisonsType;
use App\Repository\CommentaireSaisonRepository;
use App\Repository\EpisodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisonController extends AbstractController
{


    /**
     * @Route("saison/{id}/show", name="saison_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Saison $saison, EpisodeRepository $episodesRepository,CommentaireSaisonRepository $saisonRepository): Response
    {
        $episode = $episodesRepository->findBy(["Saison" => $saison],[]);
        $comments = $saisonRepository->findBy(['Saison'=>$saison]);

        return $this->render('saison/show.html.twig', [
            'saisons' => $saison,
            'episodes' => $episode,
            'comments'=>$comments
        ]);
    }

    /**
     * @Route("saison/new", name="saisons_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $saisons = new Saison();
        $form = $this->createForm(SaisonsType::class, $saisons);
        $form->handleRequest($request);

        $file = $form['image']->getData();

        if($file instanceof UploadedFile) {

            $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            try {
                $fileName = \uniqid() . \urldecode($fileInfo) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('saison_image'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Error on FileUpload : ' . $e->getMessage());

                return $this->redirectToRoute('home');
            }
            $saisons->setImage($fileName);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($saisons);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('saison/new.html.twig', [
            'saisons' => $saisons,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("saison/{id}/edit", name="saison_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Saison $saison): Response
    {
        $form = $this->createForm(SaisonsType::class, $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('saison_show',['id'=>$saison->getId()]);
        }

        return $this->render('saison/edit.html.twig', [
            'saisons' => $saison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("saison/{id}/delete", name="saison_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Saison $saison): Response
    {
        if ($this->isCsrfTokenValid('delete'.$saison->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($saison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }


}

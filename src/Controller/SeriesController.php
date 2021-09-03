<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SeriesType;
use App\Repository\CommentaireSerieRepository;
use App\Repository\SaisonRepository;
use App\Repository\SauvegardeSerieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{


    /**
     * @Route("serie/{id}/show", name="series_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Serie $series, SaisonRepository $saisonRepository, SauvegardeSerieRepository $sauvegardeSerieRepository, CommentaireSerieRepository $commentaireSerieRepository): Response
    {
        $saisons = $saisonRepository->getSeriesWithSaisons($series);
        $sauvegarde = $sauvegardeSerieRepository->getSaveByUser($this->getUser(), $series);
        $avis = $commentaireSerieRepository->findBy(['Serie' => $series]);

        return $this->render('series/show.html.twig', [
            'series' => $series,
            'saisons' => $saisons,
            'sauvegardes' => $sauvegarde,
            'avis' => $avis
        ]);
    }

    /**
     * @Route("serie/{id}/edit", name="series_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Serie $series): Response
    {
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('series_show', ['id' => $series->getId()]);
        }

        return $this->render('series/edit.html.twig', [
            'series' => $series,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("serie/{id}/delete", name="series_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Serie $series): Response
    {
        if ($this->isCsrfTokenValid('delete' . $series->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($series);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("serie/new", name="series_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $series = new Serie();
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        $file = $form['image']->getData();

        if ($file instanceof UploadedFile) {

            $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            try {
                $fileName = \uniqid() . \urldecode($fileInfo) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('serie_image'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Error on FileUpload : ' . $e->getMessage());

                return $this->redirectToRoute('home');
            }
            $series->setImage($fileName);
        }


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($series);
            $entityManager->flush();


            return $this->redirectToRoute('home');
        }

        return $this->render('series/new.html.twig', [
            'series' => $series,
            'form' => $form->createView(),
        ]);
    }


}

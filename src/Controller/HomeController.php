<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param SerieRepository $serieRepository
     * @param FilmRepository $filmRepository
     * @return Response
     */
    public function index(SerieRepository $serieRepository, FilmRepository $filmRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'list_series' => $serieRepository->getSeriesToPrint(),
            'list_films' => $filmRepository->getMovies(),
        ]);
    }
}

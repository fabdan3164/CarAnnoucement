<?php

namespace App\Controller;

use App\Repository\AnnoucementRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(AnnoucementRepository $annoucementRepository, CarRepository $carRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'annoucements' => $annoucementRepository->findAll(),
        ]);
    }


}

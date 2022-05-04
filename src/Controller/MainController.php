<?php

namespace App\Controller;

use App\Entity\Car;
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
            'annoucements2' => $annoucementRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_main_brand', methods: ['GET'])]
    public function indexBrand(AnnoucementRepository $annoucementRepository, Car $id): Response
    {
        return $this->render('main/index.html.twig', [
            'annoucements' => $annoucementRepository->findby(['id'=>$id]),
            'annoucements2' => $annoucementRepository->findAll()
        ]);
    }



}

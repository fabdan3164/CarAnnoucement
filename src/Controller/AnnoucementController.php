<?php

namespace App\Controller;

use App\Entity\Annoucement;
use App\Entity\Favorite;
use App\Form\AnnoucementType;
use App\Repository\AnnoucementRepository;
use App\Repository\FavoriteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[isGranted("ROLE_USER")]
#[Route('/annoucement')]
class AnnoucementController extends AbstractController
{
    #[Route('/', name: 'app_annoucement_index', methods: ['GET'])]
    public function index(AnnoucementRepository $annoucementRepository): Response
    {
        return $this->render('annoucement/index.html.twig', [
            'annoucements' => $annoucementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annoucement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnoucementRepository $annoucementRepository): Response
    {
        $user = $this->getUser();
        $annoucement = new Annoucement();
        $annoucement->setUser($user);
        $form = $this->createForm(AnnoucementType::class, $annoucement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupérer les données du formulaire
            $file = $form['picture']->getData();

            //Définir le chemin vers le dossier de stockage situé dans public
            $directory = './img/';

            // Vérifier si le fichier existe
            if ($file) {
                // Récupérer l'extension
                $extension = $file->guessExtension();

                // Déplacer le fichier dans le dossier de stockage
                $file->move($directory, $annoucement->getId() . '.' . $extension);

                // Définir le chemin vers l'image associée à la ville qui sera enregistré dans la base de donnée
                $annoucement->setPicture($directory .$annoucement->getId() . '.' . $extension);
            }
            $annoucementRepository->add($annoucement);
            return $this->redirectToRoute('app_annoucement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoucement/new.html.twig', [
            'annoucement' => $annoucement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annoucement_show', methods: ['GET'])]
    public function show(Annoucement $annoucement): Response
    {
        return $this->render('annoucement/show.html.twig', [
            'annoucement' => $annoucement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annoucement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annoucement $annoucement, AnnoucementRepository $annoucementRepository): Response
    {
        $form = $this->createForm(AnnoucementType::class, $annoucement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Récupérer les données du formulaire
            $file = $form['picture']->getData();

            //Définir le chemin vers le dossier de stockage situé dans public
            $directory = './img/';

            // Vérifier si le fichier existe
            if ($file) {
                // Récupérer l'extension
                $extension = $file->guessExtension();

                // Déplacer le fichier dans le dossier de stockage
                $file->move($directory, $annoucement->getId() . '.' . $extension);

                // Définir le chemin vers l'image associée à la ville qui sera enregistré dans la base de donnée
                $annoucement->setPicture($directory .$annoucement->getId() . '.' . $extension);
            }
                $annoucementRepository->add($annoucement);
            return $this->redirectToRoute('app_annoucement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoucement/edit.html.twig', [
            'annoucement' => $annoucement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annoucement_delete', methods: ['POST'])]
    public function delete(Request $request, Annoucement $annoucement, AnnoucementRepository $annoucementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoucement->getId(), $request->request->get('_token'))) {
            $annoucementRepository->remove($annoucement);
        }

        return $this->redirectToRoute('app_annoucement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('favorite/{id}', name: 'app_add_favorite', methods: ['GET'])]
    public function addFavorite(Annoucement $annoucement, FavoriteRepository $favoriteRepository) {
        // Appel l'utilisateur actuel
        $user = $this->getUser();

        // Vérifie qu'un utilisateur est bien connecté sinon renvoi vers la page d'identification
        if (!$user)
        { return $this->redirectToRoute('app_login');}

        if($annoucement->isUserFavorite($user)) {
            $signedUp = $favoriteRepository->findOneBy([
                'belong' => $user,
                'annoucement' => $annoucement
            ]);
            $favoriteRepository->remove($signedUp);
            return $this->redirectToRoute('app_main');
        }

        $signedUp = new Favorite();
        $signedUp ->setAnnoucement($annoucement)->setBelong($user);
        $favoriteRepository->add($signedUp);
        return $this->redirectToRoute('app_main');
    }

}

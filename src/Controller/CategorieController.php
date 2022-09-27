<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\MangaRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     * @Route("/categorie/{id}", name="app_tri")
     */
    public function TriCat(CategorieRepository $categorieRepository, Categorie $categorie = null, MangaRepository $mangaRepository): Response
    {
        if ($categorie !== null) {
            $mangaTri = $categorie->getMangas();
        } else {
            $mangaTri = null;
        }
        return $this->render('user/categorie.html.twig', [
            "listCategorie" => $categorieRepository->findAll(),
            // Trier en Asc orderBy('c.title', 'ASC')
            'mangaTri' => $mangaTri,
            'lastManga' => $mangaRepository->findByLastChapterAdded(9),
        ]);
    }
}

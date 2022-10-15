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
            $mangaTri = $categorie->getMangas(); //récuperer les mangas de chaque catégories
        } else {
            $mangaTri = null;
        }
        return $this->render('manga/categorie.html.twig', [
            "listCategorie" => $categorieRepository->findAll(),         //Affichage de toute les catégories
            'mangaTri' => $mangaTri,                                       //Affichages des mangas de chaque catégories
            'lastManga' => $mangaRepository->findByLastChapterAdded(9),    //Affichage des chapitres via les          
        ]);                                                                 //uptdates fais en fonction du dernier chap sortie
    }
}

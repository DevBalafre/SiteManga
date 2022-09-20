<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Repository\CategorieRepository;
use App\Repository\MangaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user")
     */
    public function index(CategorieRepository  $categorieRepository, MangaRepository $mangaRepository): Response
    {

        // ajouter un chapitre à un autre manga => vérifier si ça s'ajoute bien


        $list = $categorieRepository->findAll(); // select * from categorie
        return $this->render('user/index.html.twig', [
            "listCategorie" => $list,
            'lastManga' => $mangaRepository->findByLastChapterAdded(9),

        ]);
    }
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function AllCat(CategorieRepository  $categorieRepository): Response
    {


        $list = $categorieRepository->findAll(); // select * from categorie
        return $this->render('user/categorie.html.twig', [
            "listCategorie" => $list, 
            // Trier en Asc orderBy('c.title', 'ASC')

        ]);
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(CategorieRepository  $categorieRepository): Response
    {

        $list = $categorieRepository->findAll(); // select * from categorie
        return $this->render('user/categorie.html.twig', [
            "listCategorie" => $list,

        ]);
    }

}

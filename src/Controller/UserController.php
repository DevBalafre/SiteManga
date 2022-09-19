<?php

namespace App\Controller;

use App\Entity\Manga;

use App\Repository\CategorieRepository;
use App\Repository\ChapterRepository;
use App\Repository\MangaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user")
     */
    public function index(CategorieRepository  $categorieRepository, ChapterRepository  $ChapterRepository, MangaRepository $mangaRepository): Response
    {

        // ajouter un chapitre à un autre manga => vérifier si ça s'ajoute bien
        // ajouter un chapitre au premier manga (déjà présent) => vérifier si le manga n'apparaît pas deux fois

        $list = $categorieRepository->findAll(); // select * from categorie

        return $this->render('user/index.html.twig', [
            "listCategorie" => $list,
            'lastManga' => $mangaRepository->findByLastChapterAdded(9),


        ]);
    }
}

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

        $manga = new Manga();
        $list = $categorieRepository->findAll(); // select * from categorie
        $lastManga = $mangaRepository->findBy([], ['id' => 'DESC'], 20);
        $lastChapter = $ChapterRepository->findByAndSort([]);
        return $this->render('user/index.html.twig', [
            "listCategorie" => $list,
            'lastManga' => $lastManga,
            'lastChapter' => $lastChapter,

        ]);
    }
}

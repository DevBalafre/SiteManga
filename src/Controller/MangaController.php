<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Entity\Chapter;
use App\Entity\Comment;
use App\Form\CommentsType;
use App\Repository\UserRepository;
use App\Repository\MangaRepository;
use App\Repository\ChapterRepository;
use App\Repository\CommentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MangaController extends AbstractController
{
    /**
     * @Route("/manga/{id}", name="app_manga")
     */
    public function index(int $id, MangaRepository $mangaRepository, Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, ChapterRepository $chapterRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        $manga = $mangaRepository->findOneBy(['id' => $id]);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setUser($this->getUser()); // recupération du User
            $comment->setManga($manga);
            $comment->setDateCreation(new \DateTime()); // récupération de la date
            $manager = $doctrine->getManager();
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('app_manga', ['id' => $id, '_fragment' => 'comments']);   // vider le champs de formulaires          

        }

        $listChapter = $chapterRepository->findAll();
        return $this->render('manga/index.html.twig', [
            'commentForm' => $form->createView(),
            'listChapter' => $listChapter,
            'manga' => $manga
        ]);
    }

    /**
     * @Route("/chap/{id}", name="app_Chap")
     */
    public function chap(Chapter $currentChapter, ChapterRepository $chapterRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {

        $chapters = $chapterRepository->findBy(['manga' => $currentChapter->getManga()]); // récupère tous les chapitres du manga en cours 

        /* $chapters = $paginatorInterface->paginate(
            $donnees,
            $request->query->getInt('page', $chapter->getId()), // commence la pagination avec le chpitre cliqué
            1 // un chapitre par page
        ); */

        return $this->render('manga/detail.html.twig', [
            'currentChapter' => $currentChapter,
            'chapters' => $chapters
        ]);
    }
}

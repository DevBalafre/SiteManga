<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Entity\Comment;
use App\Form\CommentsType;
use App\Repository\UserRepository;
use App\Repository\MangaRepository;
use App\Repository\ChapterRepository;
use App\Repository\CommentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MangaController extends AbstractController
{
    /**
     * @Route("/manga/{id}", name="app_manga")
     */
    public function index(int $id, MangaRepository $mangaRepository, Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, ChapterRepository $chapterRepository, CommentRepository $commentRepository): Response
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
            return $this->redirectToRoute('app_manga', ['id' =>$id]);   // vider le champs de formulaires          

        }

        $listComments = $userRepository->findAllAndComment();
        $listChapter = $chapterRepository->findAll();
        return $this->render('manga/index.html.twig', [
            'listComments' => $listComments,
            'commentForm' => $form->createView(),
            'listChapter' => $listChapter,
            'manga' => $manga
        ]);

    }
}

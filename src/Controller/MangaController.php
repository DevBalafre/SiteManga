<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Entity\Comment;
use App\Form\CommentsType;
use App\Repository\ChapterRepository;
use App\Repository\CommentRepository;
use App\Repository\MangaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class MangaController extends AbstractController
{
    /**
     * @Route("/manga/{id}", name="app_manga")
     */
    public function index( MangaRepository $mangaRepository,Request $request, ManagerRegistry $doctrine, CommentRepository $commentsRepository, ChapterRepository $chapterRepository): Response
    {
        $comment = New Comment();
        $form = $this->createForm( CommentsType::class, $comment);
        $form->handleRequest($request);
        $manga = new Manga();
        $manga = $mangaRepository ->findOneBy(['id'=>$request->get('id')]);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($comment);
            $manager->flush();

        }
        $listComments = $commentsRepository->findByAndSort();
        $listChapter = $chapterRepository->findAll();
        return $this->render('manga/index.html.twig', [
            'listComments' => $listComments,
            'commentForm' => $form->createView(),
            'listChapter' => $listChapter

        ]);
    }
}

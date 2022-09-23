<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Manga;
use App\Form\UserType;
use App\Repository\MangaRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/profil", name="app_profil")
     */
    public function profil(){
        return $this->render('user/profil.html.twig');
    }




    /**
     * @Route("/crud", name="app_crud")
     */
    public function crud(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Profile mis à jour');
            // lorsque je sauvegarde la modif je fait une redirection
            return $this->redirectToRoute("app_user");
        }
        
        return $this->render('user/crud.html.twig', [
            'form' => $form->createView()

        ]);
    }
   

}

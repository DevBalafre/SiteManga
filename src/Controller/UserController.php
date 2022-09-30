<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\MangaRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface as PagerPaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user")
     */
    public function index(CategorieRepository  $categorieRepository, MangaRepository $mangaRepository, Request $request, PagerPaginatorInterface $paginatorInterface): Response
    {
            

        $donnees = $mangaRepository->findByLastChapterAdded(); //Récupération des dernier chapitre 

        $lastManga = $paginatorInterface->paginate(  
            $donnees,
            $request->query->getInt('page', 1),
            9
        );                                         //pagination avec un bundle

        $list = $categorieRepository->findAll(); // select * from categorie

        return $this->render('user/index.html.twig', [
            "listCategorie" => $list,
            'lastManga' => $lastManga

        ]);
    }



    /**
     * @Route("/profil", name="app_profil")
     */
    public function profil()
    {
        return $this->render('user/profil.html.twig');
    }


    /**
     * @Route("/crud", name="app_crud")
     */
    public function crud(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($hasher->isPasswordValid($user,$form->getData()->getPassword())){
                $user = $form->getData();
                $manager = $doctrine->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('sucess', 'Profile mis à jour');
                // lorsque je sauvegarde la modif je fait une redirection
                return $this->redirectToRoute("app_user");
            }else{
                $this->addFlash('error', 
                'Le mot de passe renseigné est incorect');
            }

          
        }

        return $this->render('user/crud.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="search") 
     */
    public function searchResult(RequestStack $requestStack, MangaRepository $mangaRepository,PagerPaginatorInterface $paginatorInterface, Request $request): Response
    {
        $searchedValue = $requestStack->getCurrentRequest()->get('form')['search'];
        if ($searchedValue) {
            $donnes = $mangaRepository->search($searchedValue);
        }

        $mangas = $paginatorInterface->paginate(  
            $donnes,
            $request->query->getInt('page', 1),
            9
        ); 
        return $this->render('user/searchResult.html.twig', [
            'searchedValue' => $searchedValue,
            'mangas' => $mangas
        ]);
    }

    public function searchBar(): Response
    {
        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('search', TextType::class, [
                'label' => false,
                'attr' => [
                    'minLength' => 3,
                    'maxLength' => 25,
                    'placeholder' => 'Recherche'
                ]
            ])
            ->getForm();
        return $this->render('user/searchForm.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/utlisateur/editPassword/{id}", name="search") 
     */
    public function editPassword(User $user, Request $request ): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        

        return $this->render('user/editPassword.html.twig', [ 
            'form'=> $form->createView(),
        ]);
    }
}

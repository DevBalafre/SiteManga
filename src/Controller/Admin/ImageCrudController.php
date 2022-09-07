<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }
    
    
    

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            ImageField::new('imagesChapter')
                ->setUploadDir("public/uploads/imagesChapter")
                ->setBasePath("/uploads")
                ->setRequired(false)
                ->setUploadedFileNamePattern("[contenthash].[extension]"),

            AssociationField::new("chapter")
                ->setFormTypeOption("choice_label", "title")
        ];
    }
    //Faire automatiquement l'ajout de titre 
    // public function lastTitle(ImageRepository $imageRepository, Image $image){
    //     $lastTitle= $imageRepository->findLastTitle(string);
    //     $chiffre=1;
    //     $chiffre++;
    //     return $lastTitle;
    //     $lastTitle->setTitle('Page' . $chiffre);
    //     dd($lastTitle);
    // } 
  
//     public function new(AdminContext $context)
//     {
//         $event = new BeforeCrudActionEvent($context);
//         $this->container->get('event_dispatcher')->dispatch($event);
//         if ($event->isPropagationStopped()) {
//             return $event->getResponse();
//         }

//         if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
//             throw new ForbiddenActionException($context);
//         }

//         if (!$context->getEntity()->isAccessible()) {
//             throw new InsufficientEntityPermissionException($context);
//         }

//         $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
//         $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
//         $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

//         $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
//         $newForm->handleRequest($context->getRequest());

//         $entityInstance = $newForm->getData();
//         $context->getEntity()->setInstance($entityInstance);
//         $chiffre = 1;

//         if ($newForm->isSubmitted() && $newForm->isValid()) {

//             // $chapter = $entityInstance->getChapter();
//             // $images = $chapter->getImages();

//             // $lastImage = end($images);
//             // $lastTitle = $lastImage->getTitle();
            
             

//             // $chiffre++;
//             // $lastTitle->setTitle('Page' . $chiffre);


            // dd($lastTitle);

//             // die();
//             // récupérer le title de la dernière image ($title = $image->getTitle())
//             // récupérer le chifre de ce title
//             // incrémenter de 1 ce chiffre
//             // redéfinir le title de l'image à stocker en bdd ($image->setTitle('Page' . LE_CHIFFRE))
//             // 


//             $this->processUploadedFiles($newForm);

//             $event = new BeforeEntityPersistedEvent($entityInstance);
//             $this->container->get('event_dispatcher')->dispatch($event);
//             $entityInstance = $event->getEntityInstance();

//             $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

//             $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
//             $context->getEntity()->setInstance($entityInstance);

//             return $this->getRedirectResponseAfterSave($context, Action::NEW);
//         }

//         $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
//             'pageName' => Crud::PAGE_NEW,
//             'templateName' => 'crud/new',
//             'entity' => $context->getEntity(),
//             'new_form' => $newForm,
//         ]));

//         $event = new AfterCrudActionEvent($context, $responseParameters);
//         $this->container->get('event_dispatcher')->dispatch($event);
//         if ($event->isPropagationStopped()) {
//             return $event->getResponse();
//         }

//         return $responseParameters;
//     }
}

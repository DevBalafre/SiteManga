<?php

namespace App\Controller\Admin;

use App\Entity\Manga;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MangaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manga::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            ImageField::new('photo_manga')
                ->setUploadDir("public/uploads/imageManga")
                ->setBasePath("/uploads")
                ->setRequired(false)
                ->setUploadedFileNamePattern("[contenthash].[extension]"),

            AssociationField::new("categorie")
                ->setFormTypeOption("choice_label", "title")
        ];
    }
}

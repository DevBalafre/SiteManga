<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChapterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chapter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            DateTimeField::new("date_uploads")->setFormat("dd/MM/Y HH:mm"),

            AssociationField::new("manga")
                ->setFormTypeOption("choice_label", "title")
        ];
    }
    
}

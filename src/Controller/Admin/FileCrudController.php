<?php

namespace App\Controller\Admin;

use App\Entity\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return File::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Files')
            ->setEntityLabelInSingular('File')
            ->setPageTitle('index', 'List of %entity_label_plural%')
            ->setPageTitle('new', 'Create %entity_label_singular%')
            ->setPageTitle('edit', 'Edit %entity_label_singular%');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('uploadedAt')
            ->add('link')
            ->add('title')
            ->add('description');
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('uploadedAt', 'Uploaded At')->setFormat('d/m/Y')->setFormTypeOptions(['html5' => true]);
        yield TextField::new('link', 'Link');
        yield TextField::new('title', 'Title');
        yield TextareaField::new('description', 'Description');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof File) {
            $entityInstance->setUploadedAt(new \DateTimeImmutable());
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof File) {
            $entityInstance->setUploadedAt(new \DateTimeImmutable());
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}

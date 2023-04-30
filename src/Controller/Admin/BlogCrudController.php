<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Blogs')
            ->setEntityLabelInSingular('Blog')
            ->setPageTitle('index', 'Listado de %entity_label_plural%')
            ->setPageTitle('new', 'Crear %entity_label_singular%')
            ->setPageTitle('edit', 'Editar %entity_label_singular%');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('date')
            ->add('title')
            ->add('user');
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('date', 'Fecha')->setFormat('d/m/Y')->setFormTypeOptions(['html5' => true]);
        yield TextField::new('title', 'Título');
        yield TextField::new('user', 'Usuario');
        yield TextareaField::new('text', 'Texto')->setFormTypeOptions(['attr' => ['rows' => 10]]);
        yield ArrayField::new('image', 'Imagen')->setFormType(CollectionType::class)
            ->setFormTypeOptions(['entry_type' => TextField::class, 'allow_add' => true, 'allow_delete' => true]);
    }
}

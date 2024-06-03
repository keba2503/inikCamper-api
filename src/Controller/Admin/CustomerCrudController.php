<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Customers')
            ->setEntityLabelInSingular('Customer')
            ->setPageTitle('index', 'List of %entity_label_plural%')
            ->setPageTitle('new', 'Create %entity_label_singular%')
            ->setPageTitle('edit', 'Edit %entity_label_singular%');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('country');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Name');
        yield TextField::new('email', 'Email');
        yield TextField::new('phone', 'Phone');
        yield TextField::new('country', 'Country');
    }
}

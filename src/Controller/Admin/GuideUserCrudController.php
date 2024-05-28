<?php

namespace App\Controller\Admin;

use App\Entity\GuideUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GuideUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GuideUser::class;
    }
}

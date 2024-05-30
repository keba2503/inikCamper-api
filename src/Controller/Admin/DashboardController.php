<?php

namespace App\Controller\Admin;

use App\Entity\File;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\GuideUser;
use App\Entity\Blog;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(GuideUserCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('InikCamper');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Inicio', 'fas fa-home', 'admin');
        yield MenuItem::linkToCrud('Usuarios', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Guía de Usuario', 'fas fa-file', GuideUser::class);
        yield MenuItem::linkToCrud('Blogs', 'fas fa-blog', Blog::class);
        yield MenuItem::linkToCrud('File', 'fas fa-blog', File::class);
    }
}

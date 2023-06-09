<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class GuideUserController extends AbstractController
{
    #[Route('/admin', name: 'homepage')]
    public function index(): Response
    {
        return new Response(<<<EOF
           <html>
               <body>
                    <img src="/images/under-construction.gif" />
               </body>
           </html>
           EOF
        );
    }
}

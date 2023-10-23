<?php

namespace App\Controller\site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessDeniedController extends AbstractController
{
    #[Route('/access/denied', name: 'app_access_denied')]
    public function index(): Response
    {
        return $this->render('site/access_denied/index.html.twig', [
        ]);
    }
}

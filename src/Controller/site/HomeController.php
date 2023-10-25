<?php

namespace App\Controller\site;

use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\KernelInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('site/home/index.html.twig', [

        ]);
    }

    #[Route('/email/send', name: 'app_send_email')]
    public function sendEmail(MailService $mailService, Session $session): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $mailService->sendEmail(
                $email,
                'Nouveau Contact Site Freelance',
                'emails/contact.html.twig',
                'mano.raichon@orange.fr',
                $message,
                $name
             );
        }


        return $this->redirectToRoute('app_home');

    }
}

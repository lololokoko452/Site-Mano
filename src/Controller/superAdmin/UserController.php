<?php

namespace App\Controller\superAdmin;

use App\Constants\ConstantInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class UserController extends AbstractController
{
    #[Route('superAdmin/users', name: 'app_user_index')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('superAdmin/user/index.html.twig', [
            'users' => $users,
            'SECURITY_ROLES' => ConstantInterface::SECURITY_ROLES,
        ]);
    }

    #[Route('superAdmin/users/saveRoles', name: 'app_user_save_roles')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function edit(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $formData = $request->request->all()['user_roles'];
            foreach ($formData as $userId => $roles) {
                $user = $userRepository->find($userId);
                if ($user) {
                    $newRoles = [];
                    foreach ($roles as $roleName => $role) {
                        array_push($newRoles, $roleName);
                    }
                    
                    $user->setRoles($newRoles);
                    $entityManager->persist($user);
                }
            }
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Utilisateurs maj avec succes'
            );
        }
        
        return $this->redirectToRoute('app_user_index');
    }
}

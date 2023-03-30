<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\CommentaireRepository;
use App\Repository\FormulaireDeContactRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]

    public function showComUser(CommentaireRepository $commentaireRepository,UserRepository $userRepository,FormulaireDeContactRepository $formulaireDeContactRepository): Response
    {
       
        return $this->render('admin/admin.html.twig', [
            'coms' => $commentaireRepository->findAll(),
            'users' => $userRepository->findAll(),
            'contacts' => $formulaireDeContactRepository->findAll(),
 
        ]);
    }

    
    /**
     * @Route("/delete/com/{id}", name="app_com_delete", methods={"POST"})
     */
    public function deleteCom(Request $request, Commentaire $com, CommentaireRepository $commentaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$com->getId(), $request->request->get('_token'))) {
            $commentaireRepository->remove($com, true);
            $this->addFlash('com','Commentaire supprimé avec succés');
        }

        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/user/{id}", name="app_com_delete", methods={"POST"})
     */

    public function deleteUser(Request $request,User $user,UserRepository $userRepository) :Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('admin','User supprimé avec succés'); 
        }

        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}

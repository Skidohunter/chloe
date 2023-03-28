<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\RealisationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire/{id}', name: 'app_commentaire')]
    public function index(Request $request,CommentaireRepository $commentaireRepository, Security $security,RealisationsRepository $realisationsRepository,$id): Response
    {
        $userPseudo = $security->getUser()->getPseudo();
        $com = new Commentaire();
        $com->setName($userPseudo);
        $form = $this->createForm(CommentaireType::class,$com);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $com->setRealisationId($realisationsRepository->findOneBy(['id'=>$id]));
            $commentaireRepository->add($com,true);
            return $this->redirectToRoute('app_realisations');
        }
        return $this->render('commentaire/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}

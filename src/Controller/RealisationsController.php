<?php

namespace App\Controller;

use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Repository\PrestationsRepository;
use App\Repository\RealisationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealisationsController extends AbstractController
{
    #[Route('/realisations', name: 'app_realisations')]
    public function index(Request $request,RealisationsRepository $realisationsRepository,PrestationsRepository $prestationsRepository): Response
    {
        $real = new Realisations();
        $form= $this->createForm(RealisationsType::class,$real);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $file =$form->get('img')->getData();
            if($file){
                // Méthode pour récuperer uniquement les nom de l'image sans l'extension.
               $originalNameFile = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
               // Ajout d'un nom unique avec le nom de l'image unique id et concaténation avec guessExtension qui récupere l'extension de l'img : png jpeg....
               $newFileName = $originalNameFile.uniqid().'.'.$file->guessExtension();
               //Création de la route ou sauvegarder l'img voir pense bête sur symfony
               $file->move($this->getParameter('img_directory'),$newFileName);
               //Definit le nouveau non de Img à envoyer en BDD
               $real->setImg($newFileName);
               // Permet de créer un message de succes à l'envoie du formulaire avec image
               $this->addFlash('succes','Real ajouté avec succés');
           }else{
                // Permet de créer un message de succes à l'envoie du formulaire sans image
               $this->addFlash('succes','Real random ajouté');
           }

           $realisationsRepository->add($real,true);


        }

        return $this->render('realisations/index.html.twig', [
            'form' => $form->createView(),
            'reals' => $realisationsRepository->findAll()
        ]);
    }

    
}

<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\RealisationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement/{id}', name: 'app_evenement')]
    public function index(Request $request,EvenementRepository $evenementRepository,RealisationsRepository $realisationsRepository,$id): Response
    {
        $evenement = new Evenement();
        $form= $this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $uploadedFiles =$form->get('photos')->getData();
            if($uploadedFiles){
            $evenement->setRealisationId($realisationsRepository->findOneBy(['id'=>$id]));
            $photoNames = [];
            foreach ($uploadedFiles as $uploadedFile) {                   
            $newFilename = uniqid().'.'.$uploadedFile->getClientOriginalExtension();
            $uploadedFile->move('photos_directory', $newFilename);
            $photoNames[] = $newFilename;
            
            }

            $evenement->setPhotos($photoNames);
        }
            $evenementRepository->save($evenement,true);
            return $this->redirectToRoute('app_realisations');


        }

        return $this->render('evenement/index.html.twig', [
            'form' => $form->createView(),
           
        ]);
    }

}

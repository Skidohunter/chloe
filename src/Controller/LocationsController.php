<?php

namespace App\Controller;

use App\Entity\Locations;
use App\Form\LocationsType;
use App\Repository\LocationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationsController extends AbstractController
{
    /**
     * @Route("/locations", name="app_locations")
     */
    public function index(Request $request,LocationsRepository $locationsRepository): Response
    {
        
        $loc = new Locations();
        $form = $this->createForm(LocationsType::class,$loc);
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
               $loc->setImg($newFileName);
               // Permet de créer un message de succes à l'envoie du formulaire avec image
           }

           $locationsRepository->add($loc,true);


        }

        return $this->render('locations/index.html.twig', [
            'form' => $form->createView(),
            'locs' => $locationsRepository->findAll()
        ]);
    }

    
    #[Route('/edit_locations/{id}',name:'editLoc')]
    public function formuleEdit($id ,LocationsRepository $locationsRepository,Request $request)
    {
        $loc = $locationsRepository->findOneBy(['id' => $id ]);
        $form = $this->createForm(LocationsType::class,$loc);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()){
            $locationsRepository->add($loc,true);
            return $this->redirectToRoute('app_locations');
        }
        return $this->render('locations/editLocations.html.twig',[
            'form' => $form->createView(),
            'locName'  => $loc->getName()
          
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_locations_delete", methods={"POST"})
     */
    public function delete(Request $request, Locations $loc, LocationsRepository $locationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loc->getId(), $request->request->get('_token'))) {
            $locationsRepository->remove($loc, true);
        }

        return $this->redirectToRoute('app_locations', [], Response::HTTP_SEE_OTHER);
    }
}

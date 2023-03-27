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

           $locationsRepository->add($loc,true);


        }

        return $this->render('locations/index.html.twig', [
            'form' => $form->createView(),
            'locs' => $locationsRepository->findAll()
        ]);
    }
}

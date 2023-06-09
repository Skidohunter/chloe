<?php

namespace App\Controller;

use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Repository\CommentaireRepository;
use App\Repository\EvenementRepository;
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
           }
           $realisationsRepository->add($real,true);
           $this->addFlash('succes','Real ajouté avec succés');


        }

        return $this->render('realisations/index.html.twig', [
            'form' => $form->createView(),
            'reals' => $realisationsRepository->findAll()
        ]);
    }

    #[Route('/edit_realisation/{id}',name:'editReal')]
    public function realisationEdit($id ,RealisationsRepository $realisationsRepository,Request $request)
    {
        $real = $realisationsRepository->findOneBy(['id' => $id ]);
        $form = $this->createForm(RealisationsType::class,$real);
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
           }
            $realisationsRepository->add($real,true);
            return $this->redirectToRoute('app_realisations');
        }
        return $this->render('realisations/editRealisations.html.twig',[
            'form' => $form->createView(),
            'realName'  => $real->getName()
        
          
        ]);
    }

    /**
     * @Route("/realisations/{id}", name="app_realisation_show", methods={"GET"})
     */
    public function show(CommentaireRepository $commentaireRepository,RealisationsRepository $realisationsRepository,EvenementRepository $evenementRepository, $id): Response
    {
        return $this->render('realisations/show.html.twig', [
            'real' => $realisationsRepository->findRealById($id),
            'coms' => $commentaireRepository->findBy(['realisationId'=> $id]),
            'evenements' =>$evenementRepository->findBy(['realisationId'=> $id]),
        ]);
    }

    /**
     * @Route("/realisations/delete/{id}", name="app_realisation_delete", methods={"POST"})
     */
    public function delete(Request $request, Realisations $real, RealisationsRepository $realisationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$real->getId(), $request->request->get('_token'))) {
            $realisationsRepository->remove($real, true);
        }

        return $this->redirectToRoute('app_realisations', [], Response::HTTP_SEE_OTHER);
    }

    
}

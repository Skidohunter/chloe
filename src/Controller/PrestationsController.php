<?php

namespace App\Controller;

use App\Entity\Formules;
use App\Entity\Prestations;
use App\Form\FormulesType;
use App\Form\PrestationsType;
use App\Repository\FormulesRepository;
use App\Repository\PrestationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestationsController extends AbstractController
{
    /**
     * @Route("/", name="app_prestations")
     */
    public function index(Request $request,PrestationsRepository $prestationsRepository): Response
    {
        $presta = new Prestations();
        $form = $this->createForm(PrestationsType::class,$presta);
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
               $presta->setImg($newFileName);
               // Permet de créer un message de succes à l'envoie du formulaire avec image
               $this->addFlash('succes','Presta ajouté avec succés');
           }else{
                // Permet de créer un message de succes à l'envoie du formulaire sans image
               $this->addFlash('succes','Presta random ajouté');
           }

           $prestationsRepository->add($presta,true);


        }

        return $this->render('prestations/index.html.twig', [
            'form' => $form->createView(),
            'prestas' => $prestationsRepository->findAll()
        ]);
    }

        /**
     * @Route("/formules/{id}", name="app_formules"),methods={"GET", "POST"})
     */
    public function addFormule(
        Request $request,
        FormulesRepository $formulesRepository,
        PrestationsRepository $prestationsRepository, 
        $id)
    {
       
        // Gere l'affichage
        // Le formulaire d'ajou
        $formule = new Formules();
        $form = $this->createForm(FormulesType::class,$formule);
        $form->handleRequest($request);
    
 
        if ($form->isSubmitted() && $form->isValid()) { 
            $presta = $prestationsRepository->findOneBy(['id'=>$id]);
            $formule->setRelation($presta);
            $formulesRepository->add($formule,true);
            
        }
        $prestation = $prestationsRepository->findFormulesByPresta($id);
        
        return $this->render('formules/index.html.twig', [
            'form' => $form->createView(),
            'prestation' => $prestation,
           
        ]);
    }

    #[Route('/remove_formules/{id}',name:'remove')]
    public function removeFormule(FormulesRepository $formulesRepository, $id){

        $formule = $formulesRepository->findOneBy(['id' => $id ]);
        $formulesRepository->remove($formule ,true );

        return $this->redirectToRoute('app_prestations');


    }

    #[Route('/edit_formules/{id}',name:'edit')]
    public function formuleEdit($id ,FormulesRepository $formulesRepository,Request $request)
    {
        $formule = $formulesRepository->findOneBy(['id' => $id ]);
        $formuleForm = $this->createForm(FormulesType::class,$formule);
        $formuleForm->handleRequest($request);
       
        if($formuleForm->isSubmitted() && $formuleForm->isValid()){
            $formulesRepository->add($formule,true);
            return $this->redirectToRoute('app_formules',['id' => $formule->getRelation()->getId()]);
        }
        return $this->render('formules/editFormule.html.twig',[
            'form' => $formuleForm->createView(),
            'formuleName'  => $formule->getName()
          
        ]);
    }
    
    

    
}

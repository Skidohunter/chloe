<?php

namespace App\Controller;

use App\Entity\FormulaireDeContact;
use App\Form\FormulaireDeContactType;
use App\Repository\FormulaireDeContactRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireDeContactController extends AbstractController
{
    #[Route('/formulaire/de/contact', name: 'app_formulaire_de_contact')]
    public function index(Request $request,FormulaireDeContactRepository $formulaireDeContactRepository): Response
    {

        $contact = new FormulaireDeContact();
        $date = new DateTime();
        $contact->setDate($date);
        $form = $this->createForm(FormulaireDeContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formulaireDeContactRepository->add($contact,true);
            return $this->redirectToRoute('app_prestations');
        }

        return $this->render('formulaire_de_contact/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
       
    }

    #[Route('/a/propos', name: 'app_a_propos')]
    public function aPropos()
    {
        return $this->render('a_propos/index.html.twig');
    }
}

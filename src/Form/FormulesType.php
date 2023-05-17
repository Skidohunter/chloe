<?php

namespace App\Form;

use App\Entity\Formules;
use App\Entity\Prestations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FormulesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('prix')
            ->add('img',FileType::class,[
                'label' => 'Image de la presta',
                'required' => false,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                    ],
                    'mimeTypesMessage' => 'Seul les formats png, jpg ou jpeg sont acceptés'              
               ])
            ]
            ])
            ->add('pdfFile', FileType::class, [
                'label' => 'PDF File',
                'required' => false,
            ])
            ->add('Envoyer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formules::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    private function getConfiguration($titre, $place){
        return [
                "label"=>$titre, 'attr'=>[
                    "placeholder"=>$place
                ]
            ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,$this->getConfiguration("Titre", "Saisir le titre"))
            ->add('adresse',TextType::class,$this->getConfiguration("Adresse", "Saisir l'adresse"))
            ->add('prix',MoneyType::class,$this->getConfiguration("Prix","Saisir le prix "))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","La description globale de l'annonce"))
            ->add('contenu',TextareaType::class,$this->getConfiguration("Contenu","Donner une description detaillée de l'annonce"))
            ->add('appImage',UrlType::class,$this->getConfiguration("Image","L'url de l'image"))
            ->add('chambre',IntegerType::class,$this->getConfiguration("Nbre chambre","Le nombre de chambre"))
            ->add('images',CollectionType::class,
               [ 'entry_type'=>ImageType::class,
               'allow_add' => true,
               'allow_delete' => true
               ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}

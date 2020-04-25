<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdController extends AbstractController
{
    /**
     * @Route("/ad", name="ad_liste")
     */
    public function index(AdRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * 
     * @Route("/ad/nouveau", name="nouveau_annonce")
     * 
     * @return Response
     */
    public function creation(Request $request, EntityManagerInterface $manager){
        $ad = new Ad();

        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $ima){
                $ima->setAd($ad);
                $manager->persist($ima);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',
                "L'annonce {$ad->getTitre()} a été enregistrer !"
            );
            return $this->redirectToRoute("show_adresse",[
                "adresse"=> $ad->getAdresse()
            ]);
        }

        return $this->render('ad/nouveau.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * 
     * 
     * @Route("/ad/{adresse}/modifier", name="modifier")
     * 
     */
    public function modifier(Ad $ad, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $ima){
                $ima->setAd($ad);
                $manager->persist($ima);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',
                "La modification reussi !"
            );
            return $this->redirectToRoute("show_adresse",[
                "adresse"=> $ad->getAdresse()
            ]);
        }

        return $this->render('ad/modifier.html.twig',[
            'form' =>$form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * 
     * 
     * @Route("/ad/{adresse}", name="show_adresse")
     * 
     * @return Response
     */    
    public function show(Ad $ad){
        return $this->render('ad/show.html.twig',[
            'ad'=> $ad,
        ]);
    }
}

<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/hello",name="hello")
     * 
     * @return void
     */
    public function hello(){
        return new Response("Bonjour ...");
    }

    /**
    * @Route("/", name="homepage")
    */
    public function home(){
        $prenoms = ["phat","Melodie","Simone","Dauset"];
        return $this->render(
            "home.html.twig",
            [
                'titre'=>"Melodie de papa",
                'age'=>10,
                'tableau'=>$prenoms
            ]
        ) ;
    }
}
?>
<?php


namespace App\Controller;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaginationController extends AbstractController{
    /**
     * @Route("/find/{thing}/{subcat}/{number}")
     */
    function pagination($thing, $subcat, $number){
        if(!isset($_SESSION)){
            session_start();
        }
        $logged = NULL;
        $login = NULL;
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        $recordsOnSite = 11;
        $elements = $this->getDoctrine()->getRepository(Books::class)->findElements($thing, $subcat);
        $recordsToDisplay = [];
        for($i = 0; $i < ($recordsOnSite ); $i++){
            if($i + $recordsOnSite*($number-1) >= count($elements)){
                break;
            }
            $recordsToDisplay[] = $elements[$i + $recordsOnSite*($number-1)];
        }
        $lastSite = intval(count($elements)/$recordsOnSite + 1);
        $what = $thing;
        $subcat_name = $subcat;
        if($thing == "ksiazka") $what = "książki";
        if($thing == "gra") $what = "Gry Planszowe";
        else if($thing == "gra-planszowa") $what = "Gry planszowe";
        else if($thing == "inne-produkty") $what = "Inne produkty";
        if($subcat == "kryminal") $subcat_name = "kryminały";
        else if($subcat =="literatura-piekna") $subcat_name = "literatura piękna";
        if($subcat == "dla-dzieci") $subcat_name = "dla dzieci";
        if($subcat == "film-na-cd") $subcat_name = "film na cd";
        return $this->render('pages.html.twig',[
            'logged' => $logged,
            'login' => $login,
            'books' => $recordsToDisplay,
            'thing' => $thing,
            'subcat' =>$subcat,
            'site' => $number,
            'what' => $what,
            'subcat_name' => $subcat_name,
            'last_site' => $lastSite
        ]);
    }
}
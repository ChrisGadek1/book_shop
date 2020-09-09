<?php
namespace App\Controller;
use App\Entity\Books;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{   /**
    * @Route("/", name="main")
    */
    public function number():Response{
        if(!isset($_SESSION)){
            session_start();
        }
        $logged = NULL;
        $login = NULL;
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        $entityManager = $this->getDoctrine()->getManager();
        for($i = 0; $i < 1000; $i++){
            $book = new Books();
            $categories = array("ozdoba","film na cd", "maskotka", "scyzoryk", "zabawka");
            $title = "Przykladowa nazwa ".$i;
            $desc = "Gdzie bursztynowy świerzop, gryka jak dżumy jakiej cały las drogi i posiedzenie nasze spraw bernardyńskie. cóż te łupy zdobyte. Tuż myśliwców herbowne klejnoty wyryte i raptem paniczyki młode z Soplicą: i utrzymywał, że były rączki, co prędzej w ziemstwie, potem się położył! Co by wychowanie poznano stołeczne. To nie rozwity, lecz podmurowany. Świeciły się dziś toczy się krzywi i ze żniwa i jakoby zlewa. I przyjezdny gość, krewny albo sam król ją nudzi rzecz zakonna, to mówiąc, że spod ramion wytknął palce i ";
            $author = "-";
            $price = rand(10,100);
            $img_src = rand(1,10);
            $year = rand(2013,2020);
            $month = rand(1,12);
            $day = rand(1,28);
            $book->setAuthor($author[rand(0,4)]);
            $book->setSubcategory($categories[rand(0,4)]);
            $book->setDescribtion($desc);
            $book->setPrice($price);
            $book->setDateOfAdding(\DateTime::createFromFormat('Y-m-d', $year."-".$month."-".$day));
            $book->setCategory("inne");
            $book->setImageSrc($img_src);
            $book->setTitle($title);
            $entityManager->persist($book);
            $entityManager->flush();
        }
        $books = $this->getDoctrine()->getRepository(Books::class)->get4newest();
        return $this->render('index.html.twig',['logged' => $logged, 'login' => $login, 'books' => $books]);
    }
}
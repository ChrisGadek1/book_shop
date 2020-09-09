<?php


namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegisterController extends AbstractController{
    /**
     * @Route("/register")
     */
    function register():Response{
        if(!isset($_SESSION)){
            session_start();
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $logged = NULL;
        $login = NULL;
        $user_email = "";
        $user_login = "";
        $password_1 = "";
        $password_2 = "";
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }

        if(isset($_POST['user_login'])){
            $repository = $this->getDoctrine()->getRepository(Users::class);
            $user = $repository->findOneBy(['login' => $_POST['user_login']]);
            $everythingOK = true;
            $email_error = NULL;
            $login_error = NULL;
            $password_error_1 = NULL;
            $password_error_2 = NULL;
            $reg_error = NULL;
            $captcha_error = NULL;
            $user_email = $_POST['user_email'];
            $user_login = $_POST['user_login'];
            $password_1 = $_POST['user_password_1'];
            $password_2 = $_POST['user_password_2'];
            if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
                $everythingOK = false;
                $email_error = "Podaj poprawny email";

            }
            if($everythingOK && $user){
                $everythingOK = false;
                $login_error = "Taki login już istnieje";
            }
            if($everythingOK && !ctype_alnum($_POST['user_login'])){
                $everythingOK = false;
                $login_error = "Login może składać się tylko z liter i cyfr";
            }
            if($everythingOK  && !(strlen($_POST['user_password_1']) > 8 && strlen($_POST['user_password_1']) < 30)){
                $everythingOK = false;
                $password_error_1 = "Hasło musi mieć długość od 8 do 30 znaków";
            }
            $p = $_POST['user_password_1'];
            if($everythingOK && !(preg_match("/^.*[a-z].*$/",$p) && preg_match("/^.*[A-Z].*$/", $p) && preg_match("/^.*[0-9].*$/",$p))){
                $everythingOK = false;
                $password_error_1 = "Wymagane duże i małe litery oraz cyfry";
            }
            if($everythingOK && $_POST['user_password_1'] != $_POST['user_password_2']){
                $everythingOK = false;
                $password_error_2 = "Hasła nie są takie same";
            }
            if($everythingOK && !isset($_POST['acceptation'])){
                $everythingOK = false;
                $reg_error = "Aby założyć konto należy akceptować regulamin";
            }
            if($everythingOK){
                try{
                    //$secret = "6LftqcMZAAAAAIFWFlUSgy94vFlL6uY8ojwkpzwf"; //klucz na localhost
                    $secret = "6Le5MMoZAAAAAF3WLIMXW9FuQ0B6hSR0PLv26v0G"; //klucz na heroku
                    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                    $answer = json_decode($check);
                    if($answer->success == false){
                        $everythingOK = false;
                        $captcha_error = "Potwierdź, że nie jesteś robotem";
                    }
                }
                catch(\Exception $e){
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }
            if($everythingOK){
                try{
                    $manager = $this->getDoctrine()->getManager();
                    $new_user = new Users();
                    $new_user->setPassword(password_hash($_POST['user_password_1'], PASSWORD_DEFAULT));
                    $new_user->setLogin($_POST['user_login']);
                    $new_user->setEmail($_POST['user_email']);
                    $manager->persist($new_user);
                    $manager->flush();
                    return $this->redirectToRoute('registered');
                }
                catch (\Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), " błąd przy wprowadzaniu do bazy danych";
                }
            }
            else{
               return $this->render('register.html.twig',['logged' => $logged,
                   'login'=> $login,
                   'email_error' => $email_error,
                   'login_error' => $login_error,
                   'password_error_1' => $password_error_1,
                   'password_error_2' => $password_error_2,
                   'reg_error' => $reg_error,
                   'captcha_error' => $captcha_error,
                   'user_email' => $user_email,
                   'user_login'=> $user_login,
                   'password_1' => $password_1,
                   'password_2' => $password_2]);
            }
        }
        else return $this->render('register.html.twig',['logged' => $logged,
            'login'=>$login,
            'user_email' => $user_email,
            'user_login'=> $user_login,
            'password_1' => $password_1,
            'password_2' => $password_2]);
    }
}
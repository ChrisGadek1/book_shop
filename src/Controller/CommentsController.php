<?php


namespace App\Controller;
use App\Entity\Opinions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentsController extends AbstractController{
    /**
     * @Route("/getComments")
     * @return JsonResponse
     */
    function getComments():JsonResponse{
        $q = $_REQUEST['q'];
        $part = $_REQUEST['part'];
        $response = [];
        $numberOfComments = 10;
        $comments = $this->getDoctrine()->getRepository(Opinions::class)->getComments($q);
        for($i = ($part - 1)*$numberOfComments; $i < $part*$numberOfComments && $i < count($comments); $i++){
            $response[] = array(
                'id' => $comments[$i]->getId(),
                'ocena' => $comments[$i]->getOcena(),
                'opinia' => $comments[$i]->getOpinia(),
                'user' => $comments[$i]->getUser()->getLogin(),
                'date' => $comments[$i]->getDataDodania()->format('Y-m-d')
            );
        }
        if(count($comments) < $numberOfComments) $response[] = array('more' => false);
        else $response[] = array('more' => true);
        if(count($comments) <= $part*$numberOfComments) $response[] = array('last' => true);
        else $response[]  = array('last' => false);
        return new JsonResponse(json_encode($response));

    }
}
<?php

namespace App\Service;

use App\Entity\User;
use DateTime;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class EmailService
 * @package App\Service
 */
class EmailService extends AbstractController
{

    /**
     * @param         $user
     * @param Request $request
     *
     * @return bool
     */
    public function sendRegistrationEmail($user , Request $request){

        $subject = 'Confirmation de votre compte chez Snowtricks';
        $content = $this->renderView('emails/registration.html.twig', [
            'name' => $user->getfname().' '.$user->getlname(),
            'link' => $request->server->get('SERVER_NAME').'/confirm?id='.$user->getId().'&token='.$user->getToken()
        ]);
        $headers = 'From: "Snowtricks"<romain.alix89@gmail.com>' . "\n";
        $headers .= 'Reply-To: romain.alix89@gmail.com' . "\n";
        $headers .= 'Content-Type: text/html; charset="iso-8859-1"' . "\n";
        $headers .= 'Content-Transfer-Encoding: 8bit';
        if(mail($user->getEmail(), $subject, $content, $headers)){
            $this->addFlash('success','Un e-mail viens de vous être envoyé, vous avez à présent 30 minutes pour activer votre compte.');
            return true;
        };
        $this->addFlash('error','Oups ! Un problème est survenu lors de l\'envoie de votre email.');
        return false;
    }
}

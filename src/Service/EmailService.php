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

        $subject = 'Confirmation de compte';
        $content = $this->renderView('emails/registration.html.twig', [
            'username' => $user->getUsername(),
            'id' => $user->getId(),
            'token' => $user->getConfirmationToken(),
            'address' => $request->server->get('SERVER_NAME')
        ]);
        $headers = 'From: "Snowtricks"<romain.alix89@gmail.com>' . "\n";
        $headers .= 'Reply-To: romain.alix89@gmail.com' . "\n";
        $headers .= 'Content-Type: text/html; charset="iso-8859-1"' . "\n";
        $headers .= 'Content-Transfer-Encoding: 8bit';
        if(mail($user->getEmail(), $subject, $content, $headers)){
            $this->addFlash('success','Un email viens de vous être envoyer, vous avez à présent 30 minutes pour activer votre compte.');
            return true;
        };
        $this->addFlash('error','Oups ! Un problème est survenu lors de l\'envoie de votre email.');
        return false;

    }

}
<?php

namespace App\Controller;

use App\Entity\Mee;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DetailsController extends Controller
{
    /**
     * @Route("/details/{id}", name="details")
     */
    public function index($id, \Swift_Mailer $mailer)
    {
        $details = $this->getDoctrine()
        ->getRepository(Mee::class)->find($id);

        $message = (new \Swift_Message('Imran Rafique'))
        ->setFrom('comunit76@gmail.com')
        ->setTo('comunit@live.com')
        ->setBody(
            $this->renderView(
                'details/email.html.twig',
                array('details' => $details)
            ),
            'text/html'
        );

        $mailer->send($message);

        return $this->render('details/index.html.twig', [
            'controller_name' => 'DetailsController',
            'details' => $details
        ]);
    }
}

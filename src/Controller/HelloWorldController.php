<?php

namespace App\Controller;
use App\Entity\Mee;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HelloWorldController extends Controller
{
    /**
     * @Route("/{slug}", name="hello_world")
     */
    
    public function index($slug, Request $request)
    {
        $form1 = new Mee();
            $form = $this->createFormBuilder($form1)
            ->add('name', TextType::class)
            ->add('age', TextType::class)
            ->add('likes', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $formdata = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($formdata);
                $entityManager->flush();
        
                return $this->redirect($request->getUri());
            }


        $mee = $this->getDoctrine()
        ->getRepository(Mee::class)->findAll();
        return $this->render('hello-world/hello-world.html.twig', [
            'controller_name' => 'HelloWorldController',
            'mee' => $mee,
            'form' => $form->createView()
        ]);
    }
}

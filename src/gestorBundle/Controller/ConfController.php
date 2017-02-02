<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Form\ConfType;
use gestorBundle\Entity\Conf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfController extends Controller
{
    public function allAction()
    {
      $repository = $this->getDoctrine()->getRepository('gestorBundle:Conf');//Manejador de doctrine
      // find *all* confs
      $conf = $repository->findAll();
      return $this->render('gestorBundle:Default:all_conf.html.twig', array("conf"=>$conf));
    }

    public function newAction(Request $request)
    {
      $conf = new Conf();
      $form = $this->createForm(ConfType::class,$conf);

      $form -> handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         // $form->getData() holds the submitted values
         // but, the original `$task` variable has also been updated
         $conf = $form->getData();

         // ... perform some action, such as saving the task to the database
         // for example, if Task is a Doctrine entity, save it!
         $em = $this->getDoctrine()->getManager();
         $em->persist($conf);
         $em->flush();

       return $this->redirectToRoute('all_conf');
      }

      return $this->render('gestorBundle:Default:nueva_conf.html.twig', array("form"=>$form->createView()));
    }
}

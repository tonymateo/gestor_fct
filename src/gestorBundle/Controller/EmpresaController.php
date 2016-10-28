<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Form\EmpresaType;
use Symfony\Component\HttpFoundation\Request;
use gestorBundle\Entity\Empresa;

class EmpresaController extends Controller
{
    public function allAction()
    {
        $repository = $this->getDoctrine()->getRepository('gestorBundle:Empresa');//Manejador de doctrine
        // find *all* empresas
        $empresas = $repository->findAll();
        return $this->render('gestorBundle:Default:all.html.twig', array("empresas"=>$empresas));
    }

    public function newAction(Request $request)
    {
      $empresa = new Empresa();
      $form = $this->createForm(EmpresaType::class,$empresa);

      $form -> handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         // $form->getData() holds the submitted values
         // but, the original `$task` variable has also been updated
         $empresa = $form->getData();

         // ... perform some action, such as saving the task to the database
         // for example, if Task is a Doctrine entity, save it!
         $em = $this->getDoctrine()->getManager();
         $em->persist($empresa);
         $em->flush();

       return $this->redirectToRoute('all_empresa');
      }

      return $this->render('gestorBundle:Default:nueva_empresa.html.twig', array("form"=>$form->createView()));
    }
}

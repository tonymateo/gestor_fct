<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Entity\Profesores;
use gestorBundle\Form\ProfesoresType;
use Symfony\Component\HttpFoundation\Request;

class ProfesoresController extends Controller
{

  public function allAction()
  {
      $repository = $this->getDoctrine()->getRepository('gestorBundle:Profesores');//Manejador de doctrine
      // find *all* profesores
      $profesores = $repository->findAll();
      //Imprimo por pantalla todos los profesores que se encuentran dentro de la base de datos
      return $this->render('gestorBundle:Default:profesores_all.html.twig', array("profesores"=>$profesores));
  }

  public function nuevoProfesorAction(Request $request)
  {
    $profesor = new Profesores();
    $form = $this->createForm(ProfesoresType::class,$profesor);

    $form -> handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
       // $form->getData() holds the submitted values
       // but, the original `$task` variable has also been updated
       //Si el usuario le ha dado a enviar y los datos son correctos, entonces recoge los datos del formulario para posteriormente insertatlos
       $profesor = $form->getData();

       // ... perform some action, such as saving the task to the database
       // for example, if Task is a Doctrine entity, save it!
       $em = $this->getDoctrine()->getManager();
       $em->persist($profesor);
       $em->flush();

       //Una vez insertado en la base de datos redirigimos hacia todos los profesores
       return $this->redirectToRoute('all_profesores');
    }

    return $this->render('gestorBundle:Default:nuevo_profesor.html.twig', array("form"=>$form->createView()));
  }
}

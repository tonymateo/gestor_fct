<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Entity\Profesores;

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

  /*public function nuevoAlumnoAction()
    {
      //Alumno generada
      $alumno=new Alumno();
      $alumno->setNombre("Toni");
      $alumno->setApellido1("Mateo");
      $alumno->setApellido2("Vidal");
      $alumno->setCiclo("2 DAW");


      //Nuevo empresa para ese alumno
      $empresa = new Empresa();
      $empresa->setNombre("Florida");
      $empresa->setDireccion("Catarroja");
      $empresa->setCp("48903");
      $empresa->setTelefono1("892738734");
      $empresa->setTelefono2("893174384");
      $empresa->setFechaDeCreacion(new \DateTime());

      //Ligar el alumno a nuestro empresa
      $empresa->setEmpresa($alumno);

      //Guardar en la BD
      $em = $this->getDoctrine()->getManager();
      $em->persist($alumno);
      $em->persist($empresa);
      $em->flush();
    }*/
}

<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Entity\Alumno;

class AlumnoController extends Controller
{

  public function allAction()
  {
      $repository = $this->getDoctrine()->getRepository('gestorBundle:Alumno');//Manejador de doctrine
      // find *all* alumnos
      $alumnos = $repository->findAll();
      return $this->render('gestorBundle:Default:alumno_all.html.twig', array("alumnos"=>$alumnos));
  }

  public function nuevoAlumnoAction()
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
    }
}

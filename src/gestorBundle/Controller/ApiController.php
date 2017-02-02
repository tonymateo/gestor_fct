<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//Imports necesarios para peticiones post y get
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\HttpFoundation\Request;

use gestorBundle\Entity\Empresa;
use gestorBundle\Entity\Profesores;

class ApiController extends Controller
{

  private function serializeEmpresa(Empresa $empresa){
    return array(
          'nombre' => $empresa->getNombre(),
          'direccion' => $empresa->getDireccion(),
          'cp' => $empresa->getCp(),
          'telefono1' => $empresa->getTelefono1(),
          'telefono2' => $empresa->getTelefono2(),
          'fechaDeCreacion' => $empresa->getFechaDeCreacion(),
      );
  }

  public function empresasGetAction(){
    $repository = $this->getDoctrine()->getRepository('gestorBundle:Empresa');//obtener manejador de base de datos para la entidad
    $empresas = $repository->findAll();//extraer todos los datos para todas las filas

    //var_dump($empresas);
    $data = array('empresas' => array());
    foreach ($empresas as $empresa) {
      $data['empresas'][] = $this->serializeEmpresa($empresa);
    }
    $response = new JsonResponse($data, 400);
    return $response;
    //return $this->json($empresas);
  }

  //Serializo profesores con los datos que voy a recoger por JSON
  private function serializeProfesores(Profesores $profesor){
    return array(
          'nombre' => $profesor->getNombre(),
          'apellidos' => $profesor->getApellidos(),
          'departamento' => $profesor->getDepartamento(),
      );
  }

  //Metodo que uso para recoger los profesores que hay y que posteriormente meteré en el JSON
  public function profesoresGetAction(){
    $repository = $this->getDoctrine()->getRepository('gestorBundle:Profesores');//obtener manejador de base de datos para la entidad
    $profesores = $repository->findAll();//extraer todos los datos para todas las filas

    $data = array('profesores' => array());
    foreach ($profesores as $profesor) {
      $data['profesores'][] = $this->serializeProfesores($profesor);
    }
    $response = new JsonResponse($data, 400);
    return $response;
  }

  public function empresasPostAction(Request $request)
  {
    $connection=$this->getDoctrine()->getManager();
    $response = new JsonResponse();

    $content = $request->getContent();
    $content=json_decode($content);

    $empresa=new empresa();
    $empresa->setNombre($content->nombre);
    $empresa->setDireccion($content->direccion);
    $empresa->setCp($content->cp);
    $empresa->setTelefono1($content->telefono1);
    $empresa->setTelefono2($content->telefono2);
    $empresa->setFechaDeCreacion(new \DateTime($content->fechaDeCreacion));

    $connection->persist($empresa);
    $connection->flush();
    if($empresa->getId()>0){
      $data="Funciona";
    }else {
      $data="No va";
    }

    return $response->setData(array('Estado' => $data),200);
  }
}

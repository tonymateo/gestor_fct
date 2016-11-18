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

  /*$empresa1 = new Empresa();

  private function serializeEmpresa($empresa1, $data){

    return array(
          $empresa1.setNombre => $data;


      );
  }



  public function empresasPostAction(Empresa $data)
  {

    $em = $this->getDoctrine()->getManager();
    $em->persist($empresa);
    $em->flush();
  }
  */
}

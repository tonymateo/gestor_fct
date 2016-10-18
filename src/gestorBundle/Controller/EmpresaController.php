<?php

namespace gestorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmpresaController extends Controller
{
    public function allAction()
    {
        $repository = $this->getDoctrine()->getRepository('gestorBundle:Empresa');//Manejador de doctrine
        // find *all* empresas
        $empresas = $repository->findAll();
        return $this->render('gestorBundle:Default:all.html.twig', array("empresas"=>$empresas));
    }
}

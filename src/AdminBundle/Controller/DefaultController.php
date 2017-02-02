<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use gestorBundle\Form\UserType;
use gestorBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
  /**
  * @Route("/")
  */
    public function adminAction()
    {
        $user = new User();
        $plainPassword = '1234';
        $encoder = $this->container->get('security.password_encoder');
        $psswEncoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($psswEncoded);
        $user->setUsername("admin");
        $user->setEmail("admin@admin.com");
        $roles = ["ROLE_ADMIN", "ROLE_SUPER_ADMIN"];
        $user->setRoles($roles);

        // 4) save the User!
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    /**
    * @Security("has_role('ROLE_SUPER_ADMIN')")
    */
    public function getAllAction()
    {
      $repository = $this->getDoctrine()->getRepository('gestorBundle:User');//Manejador de doctrine
      // find *all* users
      $users = $repository->findAll();

      return $this->render('AdminBundle:Default:gestorUsuarios.html.twig', array("users"=>$users));
    }


    public function quitarRolesAction($roles)
    {
      $em = $this->getDoctrine()->getManager();
      $product = $em->getRepository('gestorBundle:User')->find($roles);

      if (!$product) {
          throw $this->createNotFoundException(
              'No he encontrado el rol'.$productId
          );
      }

      $product->setRoles("");
      $em->flush();
    }
}

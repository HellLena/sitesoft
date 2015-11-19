<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * @Route("/reg")
     */
    public function registerAction(Request $request)
    {
        // build the form
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if ( $form->isSubmitted() ) {
            if ($form->isValid()) {
                if($this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->findOneBy(array('username' => $user->getUsername()))) {
                    $response['id'] = "#user_username";
                    $response['error'] = 'Пользователь с таким логином существует';
                } else {
                    // Encode the password (you could also do this via Doctrine listener)
                    $password = $this->get('security.password_encoder')
                        ->encodePassword($user, $user->getPlainPassword());
                    $user->setPassword($password);

                    // save the User
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    // ... do any other work - like send them an email, etc
                    // maybe set a "flash" success message for the user
                    $response['url'] = $this->get('router')->generate('reg_success');
                }
            } else {
                $response['id'] = "#user_plainPassword_second";
                $response['error'] = "Пароли не совпадают";
            }
            return new JsonResponse($response);
        }

        return $this->render(
            'reg.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/reg_success")
     */
    public function regSuccessAction(){
        return $this->render('reg_success.html.twig');
    }
}
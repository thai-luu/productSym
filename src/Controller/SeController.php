<?php

namespace App\Controller;
use App\Document\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;

class SeController extends AbstractController
{

    /**
     * @Route("/login", name="app_login")
     */
    public function login(): Response
    {
        $session = new Session();
        $session->start();
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
    

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    { 
        session_start();
        // $session = new Session();
        // $session->start();
        // $session->clear();
        
        session_unset();
        
    
        return $this->redirectToRoute('app_login');

    }
     /**
     * @Route("/login/check", name="app_loginCheck")
     */
    public function loginCheck(Request $request, DocumentManager $dm){
        

     $email = $request->get('email');
     $password = $request->get('password');
     $repository = $dm->getRepository(User::class);
     $user = $repository->findBy(['email'=>$email,'password'=>$password]);
    

    //  $user = $dm->createQueryBuilder(User::class)
    // ->field('email')->equals($email)
    // ->field('password')->equals($password);
     if($user){
         
        $session = $this->get('session');
        $session->set('email', $email);
        $_SESSION['email']= $email;
        // echo "<pre>";
        // var_dump($_SESSION);
        // echo "</pre>";
        return $this->redirectToRoute('app_login');
     }
     $alert = 1;
     return $this->render('security/login.html.twig',['alert' =>$alert]);
    }
}

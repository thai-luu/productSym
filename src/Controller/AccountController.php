<?php
namespace App\Controller;

use App\Form\Model\Registration;
use App\Form\Type\RegistrationType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AccountController extends AbstractController
{
    /**
     * @Route("/register", name="product-register")
     */
    public function registerAction()
    {
        $form = $this->createForm(RegistrationType::class, new Registration(),[
            'action' => $this->generateUrl('/register/create'),
            'method' => 'POST',
        ]);

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/register/create", name="product-register-save",methods={"GET","POST"})
     */
    public function createAction(DocumentManager $dm, Request $request)
{
    $form = $this->createForm(RegistrationType::class, new Registration());

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $registration = $form->getData();

        $dm->persist($registration->getUser());
        $dm->flush();

        return $this->redirecttoRoute('product-index');
    }

    return $this->render('registration/register.html.twig', [
        'form' => $form->createView()
    ]
);
}
}

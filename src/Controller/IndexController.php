<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProgramRepository $programRepository,
                          Request $request,
                          UserPasswordEncoderInterface $passwordEncoder)
    {
      $programs = $programRepository->findAll();

      // Form Inscription

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('index');
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'programs' => $programs,
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/condition", name="condition")
     */
    public function condition()
    {
        return $this->render('index/condition.html.twig');
    }
    
    /**
     * @Route("/mention", name="mention")
     */
    public function mention()
    {
        return $this->render('index/mention.html.twig');
    }
}

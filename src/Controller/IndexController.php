<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\NewsletterType;
use App\Entity\Newsletter;
use App\Repository\ProgramRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ProgramRepository $programRepository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param WorkshopRepository $workshopRepository
     * @return RedirectResponse|Response
     */
    public function index(ProgramRepository $programRepository,
                          Request $request,
                          UserPasswordEncoderInterface $passwordEncoder,
                          WorkshopRepository $workshopRepository)
    {
      $programs = $programRepository->findAll();
      $workshops = $workshopRepository->findAll();

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

        //form email

        $mail = new Newsletter();
        $new = $this->createForm(NewsletterType::class, $mail);
        $new->handleRequest($request);

        if ($new->isSubmitted() ) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($mail);

			$entityManager->flush();
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'programs' => $programs,
            'workshops' => $workshops,
            'registrationForm' => $form->createView(),
            'newsletter' => $new->createView(),
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

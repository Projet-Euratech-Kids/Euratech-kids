<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\NewsletterFormType;
use App\Form\RegistrationFormType;
use App\Repository\ProgramRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
                          WorkshopRepository $workshopRepository,
                          MailerInterface $mailer)
                          
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

            // mail

            $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($user->getMail())
            ->subject('Mail confirmation')
            ->htmlTemplate('mail/confirmMail.html.twig')
            ->context([
                'user' => $user,
            ]);

            $mailer->send($email);

            return $this->redirectToRoute('index');
        }

      // Form Newsletter
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($newsletter);
          $entityManager->flush();


          return $this->redirectToRoute('index');
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'programs' => $programs,
            'workshops' => $workshops,
            'registrationForm' => $form->createView(),
            'newsletterForm' => $newsletterForm->createView(),
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

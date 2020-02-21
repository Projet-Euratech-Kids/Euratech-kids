<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\Contact;
use App\Entity\Gallery;
use App\Entity\User;
use App\Form\NewsletterFormType;
use App\Form\ContactType;
use App\Form\RegistrationFormType;
use App\Repository\ProgramRepository;
use App\Repository\WorkshopRepository;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
   * @param MailerInterface $mailer
   * @return RedirectResponse|Response
   * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
   */
  public function index(ProgramRepository $programRepository,
                        Request $request,
                        UserPasswordEncoderInterface $passwordEncoder,
                        WorkshopRepository $workshopRepository,
                        MailerInterface $mailer,
                        GalleryRepository $galleryRepository)

  {
    $programs = $programRepository->findAll();
    $workshops = $workshopRepository->findAll();
    $gallery = $galleryRepository->findAll();

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

    //Contact Form

    $contact = new Contact();
    $contactform = $this->createForm(ContactType::class, $contact);
    $contactform->handleRequest($request);

    if ($contactform->isSubmitted() && $contactform->isValid()) {

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($contact);
      $entityManager->flush();
      $email = (new TemplatedEmail())
        ->from($contact->getEmail())
        ->to('Matthieu@gmail.com')
        ->subject('Contact Euratech-Kids de la part de ' . $contact->getName())
        ->htmlTemplate('mail/contact.html.twig')
        ->context([
          'contact' => $contact,
        ]);

      $mailer->send($email);
    }

    return $this->render('index/index.html.twig', [
      'controller_name' => 'IndexController',
      'programs' => $programs,
      'workshops' => $workshops,
      'gallery' => $gallery,
      'registrationForm' => $form->createView(),
      'newsletterForm' => $newsletterForm->createView(),
      'contactform' => $contactform->createView(),
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
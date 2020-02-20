<?php

namespace App\Controller;

use App\Entity\Newsletter;
<<<<<<< HEAD
=======
use App\Entity\Contact;
use App\Entity\Gallery;
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
use App\Entity\User;
use App\Form\NewsletterFormType;
use App\Form\ContactType;
use App\Form\RegistrationFormType;
<<<<<<< HEAD
=======
use App\Form\NewsletterType;
use App\Repository\GalleryRepository;
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
use App\Repository\ProgramRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
=======
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

<<<<<<< HEAD
=======

>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ProgramRepository $programRepository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param WorkshopRepository $workshopRepository
     * @param MailerInterface $mailer
<<<<<<< HEAD
     * @return RedirectResponse|Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
=======
     * @param GalleryRepository $galleryRepository
     * @param Contact $contact
     * @return RedirectResponse|Response
     * @throws TransportExceptionInterface
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
     */
    public function index(ProgramRepository $programRepository,
                          Request $request,
                          UserPasswordEncoderInterface $passwordEncoder,
                          WorkshopRepository $workshopRepository,
<<<<<<< HEAD
                          MailerInterface $mailer)

    {
      $programs = $programRepository->findAll();
      $workshops = $workshopRepository->findAll();

      // Form Inscription
=======
                          MailerInterface $mailer,
                          GalleryRepository $galleryRepository)

    {
        $programs = $programRepository->findAll();
        $workshops = $workshopRepository->findAll();
        $gallery = $galleryRepository->findAll();

        // Form Inscription
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f

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
<<<<<<< HEAD
            ->from('hello@example.com')
            ->to($user->getMail())
            ->subject('Mail confirmation')
            ->htmlTemplate('mail/confirmMail.html.twig')
            ->context([
                'user' => $user,
            ]);
=======
                ->from('hello@example.com')
                ->to($user->getMail())
                ->subject('Mail confirmation')
                ->htmlTemplate('mail/confirmMail.html.twig')
                ->context([
                    'user' => $user,
                ]);
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f

            $mailer->send($email);

            return $this->redirectToRoute('index');
        }


<<<<<<< HEAD
      // Form Newsletter
=======
        // Form Newsletter
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {

<<<<<<< HEAD
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($newsletter);
          $entityManager->flush();


          return $this->redirectToRoute('index');
=======
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();


            return $this->redirectToRoute('index');
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
        }

        //Contact Form

<<<<<<< HEAD
        $contact = $this->createForm(ContactType::class);
        $contact->handleRequest($request);

        if ($contact->isSubmitted() && $contact->isValid()) {
            $email = (new TemplatedEmail())
                ->from('hello@example.com')
                ->to($user->getMail())
                ->subject('Mail confirmation')
                ->htmlTemplate('mail/confirmMail.html.twig')
                ->context([
                    'user' => $user,
                ]);
=======
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
                
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
            $mailer->send($email);
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'programs' => $programs,
            'workshops' => $workshops,
<<<<<<< HEAD
            'registrationForm' => $form->createView(),
            'newsletterForm' => $newsletterForm->createView(),
            'contactform' => $contact->createView(),
=======
            'gallery' => $gallery,
            'registrationForm' => $form->createView(),
            'newsletterForm' => $newsletterForm->createView(),
            'contactform' => $contactform->createView(),
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
        ]);
    }
    /**
     * @Route("/condition", name="condition")
     */
    public function condition()
    {
        return $this->render('index/condition.html.twig');
    }
<<<<<<< HEAD
    
=======

>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
    /**
     * @Route("/mention", name="mention")
     */
    public function mention()
    {
        return $this->render('index/mention.html.twig');
    }
}
<<<<<<< HEAD
=======

>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f

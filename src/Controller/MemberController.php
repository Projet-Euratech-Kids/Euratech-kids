<?php

namespace App\Controller;

use App\Entity\Kids;
use App\Entity\Program;
use App\Entity\User;
use App\Form\AddKidsType;
use App\Form\BookingFormType;
use App\Form\RegistrationFormType;
use App\Repository\KidsRepository;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member/{id}", name="member")
     * @IsGranted("ROLE_USER")
     */
    public function index(ProgramRepository $programRepository,
                          UserRepository $userRepository,
                          KidsRepository $kidsRepository,
                          User $user,
                          Request $request)
    {
        $member = $userRepository->findAll();
        $programs = $programRepository->findAll();

        $kids = $kidsRepository->findAll();

        // Modif Member

        $modifMember = $this->createForm(RegistrationFormType::class,$user);
        $modifMember->handleRequest($request);

        if ($modifMember->isSubmitted() && $modifMember->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index');
        }

        // Add Kids Form

        $addKids = new Kids();
        $add = $this->createForm(AddKidsType::class, $addKids);
        $add->handleRequest($request);

        if($add->isSubmitted() && $add->isValid()) {
            if (!$addKids->getUser()) {
                $addKids->setUser($this->getUser());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($addKids);
            $entityManager->flush();
            $this->addFlash('addkids','Votre enfant a bien etait ajoute.');

            return $this->redirectToRoute('member', ["id" => $addKids->getUser()->getId()]);
        }

        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
            'member'=> $member,
            'programs' => $programs,
            'kids' => $kids,
            'modifMember' => $modifMember->createView(),
            'addkids'=> $add->createView(),
        ]);
    }

    /**
     * @Route("/booking/{p_id}/{k_id}", name="booking")
     */
    public function booking($p_id, $k_id, KidsRepository $kidsRepository, ProgramRepository $programRepository) :Response
    {
      $kid = $kidsRepository->find($k_id);
      $prog = $programRepository->find($p_id);
      $prog->addKid($kid);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($prog);
      $entityManager->flush();

      return $this->redirectToRoute('member', ["id" => $kid->getUser()->getId()]);
    }

  /**
   * @Route("/cancel/{p_id}/{k_id}", name="cancel")
   */
  public function cancel($p_id, $k_id, KidsRepository $kidsRepository, ProgramRepository $programRepository) :Response
  {
    $k = $kidsRepository->find($k_id);
    $p = $programRepository->find($p_id);
    $p->removeKid($k);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($p);
    $entityManager->flush();

    return $this->redirectToRoute('member', ["id" => $k->getUser()->getId()]);
  }

    /**
     * @Route("/delkid/{id}",name="del_kid",methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request,Kids $kids): Response
    {
        if ($this->isCsrfTokenValid('delkids'.$kids->getId(),$request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kids);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member', ["id" => $kids->getUser()->getId()]);
    }
}

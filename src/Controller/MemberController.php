<?php

namespace App\Controller;

use App\Entity\Kids;
use App\Entity\User;
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
     * @Route("/member/{lastname}", name="member")
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

        $modifMember = $this->createForm(RegistrationFormType::class,$user);
        $modifMember->handleRequest($request);

        if ($modifMember->isSubmitted() && $modifMember->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
            'member'=> $member,
            'programs' => $programs,
            'kids' => $kids,
            'modifMember' => $modifMember->createView(),
        ]);
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

        return $this->redirectToRoute('index');
    }
}

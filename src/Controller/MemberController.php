<?php

namespace App\Controller;

use App\Repository\KidsRepository;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     * @IsGranted("ROLE_USER")
     */
    public function index(ProgramRepository $programRepository, KidsRepository $kidsRepository)
    {
      $programs = $programRepository->findAll();

      $kids = $kidsRepository->findAll();

      return $this->render('member/index.html.twig', [
        'controller_name' => 'MemberController',
        'programs' => $programs,
        'kids' => $kids,
      ]);
    }
}

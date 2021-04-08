<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

class TricksController extends AbstractController
{
    private $entityManager;

    function __construct( EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/snowtricks", name="home")
     * @param TricksRepository $tricksRepo
     * @return Response
     */
    public function index(TricksRepository $tricksRepo): Response
    {
        $tricks = $tricksRepo->findAll();
        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/snowtricks/{slug}", name="tricks_show")
     * @param                     $slug
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function show($slug): Response
    {
        $tricks = $this->entityManager->getRepository(Tricks::class)->findOneBySlug($slug);
        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'pagination'=>'rien'
        ]);
    }
}

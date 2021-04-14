<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksUpdateType;
use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function show($slug, Request $request ): Response
    {
        $tricks = $this->entityManager->getRepository(Tricks::class)->findOneBySlug($slug);


        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'form'=>'rien'

        ]);
    }
    /**
     * @Route("/modifier-tricks/{slug}", name="tricks_update")
     * @param                     $slug
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function update($slug, Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $tricks = $this->entityManager->getRepository(Tricks::class)->findOneBySlug($slug);
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           dump($form->getData());
           dd($form->get('category')->getData());
        }
        return $this->render('tricks/update.html.twig', [
            'tricks' => $tricks,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/ajouter-tricks", name="tricks_add")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function add( Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $tricks = new Tricks();
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           dump($form->getData());
           dd($form->get('category')->getData());
        }
        return $this->render('tricks/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/snowtricks/{slug}", name="tricks_delete")
     * @param                     $slug
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function delete($slug, Request $request ): Response
    {
        $tricks = $this->entityManager->getRepository(Tricks::class)->findOneBySlug($slug);


        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'pagination'=>'rien'
        ]);
    }
}

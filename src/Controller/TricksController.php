<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksUpdateType;
use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use mysql_xdevapi\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

class TricksController extends AbstractController
{
    private $em;
    private $slugify;


    function __construct( EntityManagerInterface $entityManager)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
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
        $tricks = $this->em->getRepository(Tricks::class)->findOneBySlug($slug);


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
        $tricks = $this->em->getRepository(Tricks::class)->findOneBySlug($slug);
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

            /*Gestion de l'upload du main_image'*/
            $main_file = $form->get('main_image')->getData();
            if(isset($main_file)){
                $newPath = 'asset/media/main/'.$main_file->getBasename();
                $tricks->setMainImage($newPath);
                try {
                  /*  $main_file->move(
                        $this->getParameter('img_main_directory'),
                        $newPath
                    );*/
                    throw new FileException( 'coucou' );
                } catch (FileException $e) {
                    dd($e->getMessage());
                    $this->addFlash('success', 'Echec de l\'upload du fichier!');
                }
            }
                foreach ($tricks->getMedia() as $image) {
                    $oldPath = $image->getPath();
                    $newPath = 'asset/media/img/' . substr($image->getPath(), -11, 11);
                    $image->setType('img');
                    $image->setPath($newPath);
                    $image->setName('Tricks de snowtricks ');
                    move_uploaded_file( $oldPath, $this->getParameter('kernel.project_dir').'/public/'. $newPath);
                }


            $tricks->setAuthorId($this->getUser());
            $tricks->setCreatedAt(new \DateTime());
            $tricks->setSlug($this->slugify->slugify(strtolower($tricks->getName())));
            $this->em->persist($tricks);
            $this->em->flush();
            $this->addFlash('success', 'Votre trick a été ajouté avec succés !');
            return $this->redirectToRoute('tricks_add');

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
        $tricks = $this->em->getRepository(Tricks::class)->findOneBySlug($slug);


        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'pagination'=>'rien'
        ]);
    }
}

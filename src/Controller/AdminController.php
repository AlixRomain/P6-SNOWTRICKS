<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin-dashboard", name="home_admin")
     */
    public function index(TricksRepository $repoTrick, CommentRepository $repoComment): Response
    {
        $tricks = $repoTrick->findBy([], ['id' => 'DESC'], 4);
        $comments = $repoComment->findBy([], ['id' => 'DESC'], 4);
        return $this->render('admin/dashboard.html.twig', [
            'tricks' => $tricks,
            'comments' => $comments,
        ]);
    }
}

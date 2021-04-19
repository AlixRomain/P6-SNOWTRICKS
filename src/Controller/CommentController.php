<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private $commentRepo;
    private $em;

    function __construct( EntityManagerInterface $entityManager, CommentRepository $commentRepo)
    {
        $this->em       = $entityManager;
        $this->commentRepo = $commentRepo;
    }
    /**
     * @Route("/admin/tous-les-commantaires", name="admin_comment")
     * @IsGranted("ROLE_ADMIN")
     */
    public function allComments(): Response
    {
        $comments = $this->commentRepo->findBy([],['date_create' => 'desc']);
        return $this->render('admin/all_comments.html.twig', [
            'comments' => $comments,
        ]);
    }
     /**
     * @Route("/profile/tous-les-commantaires", name="user_comment")
      * @IsGranted("ROLE_USER")
     */
    public function allUserComments(): Response
    {
        $comments = $this->commentRepo->findBy(['author' => $this->getUser()],['date_create' => 'desc']);
        return $this->render('admin/all_user_comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/profile/modifier-un-commentaire/{id}", name="update_comment")
     * @IsGranted("ROLE_USER")
     * @param Comment $comment
     */
    public function update(Comment $comment, Request $request): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Le commentaire a été mis à jour.');
            return $this->redirectToRoute('admin_comment');
        }
        return $this->render('admin/update_comment.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/profile/supprimer-un-commentaire/{id}", name="delete_comment")
     * @IsGranted("ROLE_USER")
     *
     * @param Comment $comment
     */
    public function delete( Comment $comment): Response
    {
        $this->em->remove($comment);
        $this->em->flush();
        $this->addFlash('success', 'Le commentaire a été supprimé.');
        return $this->redirectToRoute('user_comment');
    }
}

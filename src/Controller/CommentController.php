<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Route("/admin/tous-les-commantaires-de-snowtricks", name="admin_comment")
     * @IsGranted("ROLE_ADMIN")
     */
    public function allComments(): Response
    {
        $comments = $this->commentRepo->findBy([],['date_create' => 'desc']);
        return $this->render('admin/admin_comment/all_comments.html.twig', [
            'comments' => $comments,
        ]);
    }
     /**
      * @Route("/profile/tous-vos-commantaires", name="user_comment")
      *
      * @IsGranted("ROLE_USER")
     */
    public function allUserComments(): Response
    {
        $comments = $this->commentRepo->findBy(['author' => $this->getUser()],['date_create' => 'desc']);
        return $this->render('admin/admin_comment/all_user_comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/profile/modifier-un-commentaire/{id}", name="update_comment")
     * @IsGranted("ROLE_USER")
     * @Security(
     *      "user === comment.getAuthor() || is_granted('ROLE_ADMIN')",
     *      message = "Vous n'avez pas les droits pour modifier ce commentaire !"
     * )
     * @param Comment $comment
     * @param Request $request
     *
     * @return Response
     */
    public function update(Comment $comment, Request $request): Response
    {
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Yes! Le commentaire a bien ??t?? mis ?? jour.');
            return $this->redirectToRoute('user_comment');
        }
        return $this->render('admin/admin_comment/update_comment.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/supprimer-un-commentaire/{id}", name="delete_comment")
     * @Security(
     *      "user === comment.getAuthor() || is_granted('ROLE_ADMIN')",
     *      message = "Vous n'avez pas les droits pour supprimer ce commentaire !"
     * )
     * @IsGranted("ROLE_USER")
     *
     * @param Comment $comment
     *
     * @return Response
     */
    public function delete( Comment $comment): Response
    {
        $this->em->remove($comment);
        $this->em->flush();
        $this->addFlash('success', 'Yes! Le commentaire a bien ??t?? supprim?? de notre base de donn??e.');
        return $this->redirectToRoute('user_comment');
    }
}

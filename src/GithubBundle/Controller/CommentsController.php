<?php

namespace GithubBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GithubBundle\Entity\Comments;
use CmsBundle\Form\CommentsType;
/**
 * Comment controller.
 *
 */
class CommentsController extends Controller
{
    /**
     * Lists all comment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('GithubBundle:Comments')->findAll();

        return $this->render('GithubBundle:Comments:index.html.twig', array(
            'comments' => $comments,
        ));
    }

    /**
     * Creates a new comment entity.
     *
     */
    public function newAction(Request $request)
    {
        $username = $request->get('username');


        $ch = curl_init('https://api.github.com/users/' . $username . '/repos');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/vnd.github.v3+json',
          'User-Agent: GitHub-username'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($ch);
        curl_close($ch);

        $character = json_decode($json);
        $res = $character;
        $em = $this->getDoctrine()->getManager();

        $allComments = $em->getRepository('GithubBundle:Comments')->findByUsername($username);

        $comment = new Comments();
        $form = $this->createForm('GithubBundle\Form\CommentsType', $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $repoName = $form->get('name')->getData();

            foreach ($res as $key => $value) {
                if ($value -> full_name == $repoName) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($comment);
                    $em->flush();

                    $request->getSession()
                        ->getFlashBag()
                        ->add('success',  'Le commentaire a bien été créé')
                    ;

                    return $this->redirectToRoute(':username_comments_new', array(
                        'username' => $username,
                    ));
                }
            }
            $request->getSession()
                ->getFlashBag()
                ->add('danger',  'Une erreur est survenue. Veuillez vérifier le nom du repo et réessayer.')
            ;
            return $this->redirectToRoute(':username_comments_new', array(
                'username' => $username,
            ));
        }


        return $this->render('GithubBundle:Comments:new.html.twig', array(
            'items' => $res,
            'username' => $username,
            'comment' => $comment,
            'comments' => $allComments,
            'form' => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing comment entity.
     *
     */
    public function editAction(Request $request, Comments $comment)
    {



        $username = $request->get('username');
        $ch = curl_init('https://api.github.com/users/' . $username . '/repos');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/vnd.github.v3+json',
          'User-Agent: GitHub-username'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($ch);
        curl_close($ch);

        $character = json_decode($json);
        $res = $character;


        $deleteForm = $this->createDeleteForm($comment, $username);
        $editForm = $this->createForm('GithubBundle\Form\CommentsType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $repoName = $editForm->get('name')->getData();

            foreach ($res as $key => $value) {
                if ($value -> full_name == $repoName) {
                    $this->getDoctrine()->getManager()->flush();


                    $request->getSession()
                        ->getFlashBag()
                        ->add('success',  'Le commentaire a bien été édité')
                    ;


                    return $this->redirectToRoute(':username_comments_new', array(
                        'username' => $username,
                    ));
                }
            }
            $request->getSession()
                ->getFlashBag()
                ->add('danger',  'Une erreur est survenue. Veuillez vérifier le nom du repo et réessayer.')
            ;
        }




        return $this->render('GithubBundle:Comments:edit.html.twig', array(
            'comment' => $comment,
            'username' => $username,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     */
    public function deleteAction(Request $request, Comments $comment)
    {
        $username = $request->get('username');
        $form = $this->createDeleteForm($comment, $username);

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute(':username_comments_new', array(
            'username' => $username,
        ));
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comments $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comments $comment, $username)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl(':username_comments_delete', array('id' => $comment->getId(), 'username'=>$username)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

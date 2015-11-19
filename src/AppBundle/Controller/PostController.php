<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            // get current user for this post
            $user = $this->get('security.context')->getToken()->getUser();
            $post->setUserId($user);
            $post->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $em->flush();

            $response['post'] = array("user" => $user->getUsername(), "created_at" => $post->getCreatedAt(), "post" => $post->getPost());

            return new JsonResponse($response);
        } else {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                'SELECT user.username, post.created_at, post.post
                 FROM AppBundle:User user, AppBundle:Post post
                 WHERE user.id = post.user_id
                 ORDER BY post.created_at DESC'
            );

            $posts = $query->getResult();
        }

        return $this->render(
            'index.html.twig',
            array('form' => $form->createView(), 'posts' => $posts)
        );
    }
}
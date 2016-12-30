<?php

namespace Ilyasse\BlogBundle\Controller;

use Ilyasse\BlogBundle\Entity\Comment;
use Ilyasse\BlogBundle\Entity\Contact;
use Ilyasse\BlogBundle\Entity\Post;
use Ilyasse\BlogBundle\Form\Type\CommentType;
use Ilyasse\BlogBundle\Form\Type\ContactType;
use Ilyasse\BlogBundle\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1)
        {
            throw new NotFoundHttpException('Page ".$page." doesn\'t exist.');
        }

        $nbPerPage = 3;

        $PostsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('IlyasseBlogBundle:Post')
            ->getPosts($page, $nbPerPage)
        ;

        $nbPages = ceil(count($PostsList) / $nbPerPage);
        if($nbPages == 0)
        {
            $page = 1;
            $nbPages = 1;
        }
        else if ($page > $nbPages)
        {
            throw new NotFoundHttpException('Page ".$page." doesn\'t exist.');
        }

        return $this->render('IlyasseBlogBundle:Post:index.html.twig', array(
            'postsList' => $PostsList,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }

    public function listAction($author)
    {
        $PostsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('IlyasseBlogBundle:Post')
            ->getMyPosts($author)
        ;

        return $this->render('IlyasseBlogBundle:Post:list.html.twig', array(
            'postsList' => $PostsList,
        ));
    }

    public function viewAction(Post $post, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $comment->setUser($user);
            $post->addComment($comment);

            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'hhh');

            return $this->redirectToRoute('ilyasse_blog_view', array('id' => $post->getId()));
        }

        $comments = $em->getRepository('IlyasseBlogBundle:Comment')->findBy(array('post' => $post));
        return $this->render('IlyasseBlogBundle:Post:view.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }


    public function addAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $post->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('ilyasse_blog_view', array('id' => $post->getId()));
        }

        return $this->render('IlyasseBlogBundle:Post:add.html.twig', array('form' => $form->createView(),
        ));
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Contact Enquiry')
                ->setFrom('contact@example.com')
                ->setTo('contact@example.com')
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'IlyasseBlogBundle:Blog:contactEmail.html.twig',
                        array('contact' => $contact)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('notice', 'Your contact enquiry was successfully sent. Thank you!');
        }

        return $this->render('IlyasseBlogBundle:Blog:contactForm.html.twig', array('form' => $form->createView(),
        ));
    }


    public function aboutAction()
    {
        return $this->render('IlyasseBlogBundle:Blog:about.html.twig');
    }


}

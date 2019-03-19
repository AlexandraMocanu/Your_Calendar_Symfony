<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\tvshow;
use AppBundle\Entity\movie;
use AppBundle\Entity\User;
use AppBundle\Entity\news;
use AppBundle\Entity\comments;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Doctrine\Common\Collections\Collection;



class CommentsController extends WebbController
{

     /**
      * @Route("/addcomment/{id}_{belongsTo}", name="addcomment")
      * id belongs to a movie/tvshow/news article/
      */
     public function addCommentAction($id, $belongsTo, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $comment = new comments();

        $form = $this->createFormBuilder($comment)
            ->add('title', TextType::class)
            ->add('comment', TextType::class)
            //->add('published', DateType::class)
            //->add('user', TextType::class)
            //->add('belongsTo', TextType::class, array('label' => 'Main Picture'))
            //these from above are being set automatically below the belongsTo ifs
            ->add('save', SubmitType::class, array('label' => 'Create Comment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              // $form->getData() holds the submitted values
              $data = $form->getData();

              // set the fields that don't depend on user input
              $em = $this->getDoctrine()->getManager();

              if($belongsTo == "news"){
                  $belongsTo = $this->getDoctrine()->getRepository(news::class)->find($id);
                  if (!$belongsTo) {
                        throw $this->createNotFoundException(
                          'No news found for id '.$id
                        );
                  }
                  $comment->setBelongsToNews($belongsTo);
              }
              if($belongsTo == "tvshow"){
                  $belongsTo = $this->getDoctrine()->getRepository(tvshow::class)->find($id);
                  if (!$belongsTo) {
                        throw $this->createNotFoundException(
                          'No tvshow found for id '.$id
                        );
                  }
                  $comment->setBelongsToTVShow($belongsTo);
              }
              if($belongsTo == "movie"){
                  $belongsTo = $this->getDoctrine()->getRepository(movie::class)->find($id);
                  if (!$belongsTo) {
                        throw $this->createNotFoundException(
                          'No tvshow found for id '.$id
                        );
                  }
                  $comment->setBelongsToMovie($belongsTo);
              }

              $comment->setPublished(new \DateTime('now'));
              $comment->setUser($this->getUser());

              //persist the rest of the data from the form
              $em->persist($data);
              $em->flush();

              return $this->redirect($referer);

         }

         return $this->render('webbb/addcomment.html.twig', array(
            'form' => $form->createView(),
        ));

     }

     /**
      * @Route("/deletecomment/{id_comment}", name="deletecomment")
      */
     public function deleteCommentAction($id_comment, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $em = $this->getDoctrine()->getManager();
        $comment = $this->getDoctrine()->getRepository(comments::class)->find($id_comment);

        if (!$comment) {
              throw $this->createNotFoundException(
                'No comment found for id '.$id_comment
              );
        }


        $em->remove($comment);
        $em->flush();

        return $this->redirect($referer);

     }

     /**
      * @Route("/updatecomment/{id_comment}", name="updatecomment")
      */
     public function UpdateCommentAction($id_comment, Request $request)
     {
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();
       $comment = $this->getDoctrine()->getRepository(comments::class)->find($id_comment);

       if (!$comment) {
             throw $this->createNotFoundException(
               'No comment found for id '.$id_comment
             );
       }

       $newcomment = new comments();

       $form = $this->createFormBuilder($newcomment)
             ->add('title', TextType::class, array('data' => $comment->getTitle()))
             ->add('comment', TextType::class, array('data' => $comment->getComment()))
             ->add('save', SubmitType::class, array('label' => 'Update Comments'))
       ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             $data = $form->getData();

             // set the fields that don't depend on user input
             $em = $this->getDoctrine()->getManager();
             if($comment->getBelongsToNews()){
               $belongsTo = "news";
             }else if($comment->getBelongsToMovie()){
               $belongsTo = "movie";
             }else{
               $belongsTo = "tvshow";
             }

             if($belongsTo == "news"){
                 $comment->setBelongsToNews($comment->getBelongsToNews());
             }
             if($belongsTo == "tvshow"){
                 $comment->setBelongsToTVShow($comment->getBelongsToTVShow());
             }
             if($belongsTo == "movie"){
                 $comment->setBelongsToMovie($comment->getBelongsToMovie());
             }

             $comment->setPublished(new \DateTime('now'));
             $comment->setUser($this->getUser());

             $comment->setTitle($data->getTitle());
             $comment->setComment($data->getComment());
             //persist the rest of the data from the form

             $em->persist($comment);
             $em->flush();
             $em->remove($newcomment);
             $em->flush();

             return $this->redirect($referer);

        }

        return $this->render('webbb/updatecomment.html.twig', array(
           'form' => $form->createView(),
       ));

     }

     /**
      * @Route("/comments/byUser", name="comments_by_user")
      */
     public function commentsUserShowAction()
     {
         $dm = $this->getDoctrine()->getManager();

         $user = $this->getUser();

         if (!$user) {
               throw $this->createNotFoundException(
                 'Not logged in!'
               );
         }

         $comments = new \Doctrine\Common\Collections\ArrayCollection();

         $comments = $dm->getRepository('AppBundle:comments')->findAllByUser($user);

         return $this->render('webbb/commentsUser.html.twig',array('comments' => $comments));
     }

     /**
      * @Route("/comments/tvshow/{id_tvshow}", name="comments_tvshow")
      */
     public function commentsTVShowAction($id_tvshow)
     {
         $dm = $this->getDoctrine()->getManager();
         $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id_tvshow);

         if (!$tvshow) {
               throw $this->createNotFoundException(
                 'Could not find tv show with id '.$id_tvshow
               );
         }

         $comments = new \Doctrine\Common\Collections\ArrayCollection();

         $comments = $dm->getRepository('AppBundle:comments')->findAllByTVShow($tvshow);

         return $this->render('webbb/comments.html.twig',array('comments' => $comments));
     }

     /**
      * @Route("/comments/movie/{id_movie}", name="comments_movie")
      */
     public function commentsMovieAction($id_movie, Request $request)
     {

         $dm = $this->getDoctrine()->getManager();
         $movie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

         if (!$movie) {
               throw $this->createNotFoundException(
                 'Could not find movie with id '.$id_movie
               );
         }

         $comments = new \Doctrine\Common\Collections\ArrayCollection();

         $comments = $dm->getRepository('AppBundle:comments')->findAllByMovie($movie);

         return $this->render('webbb/comments.html.twig',array('comments' => $comments));
     }

     /**
      * @Route("/comments/mnews/{id_news}", name="comments_news")
      */
     public function commentsNewsAction($id_news, Request $request)
     {

         $dm = $this->getDoctrine()->getManager();
         $news = $this->getDoctrine()->getRepository(news::class)->find($id_news);

         if (!$news) {
               throw $this->createNotFoundException(
                 'Could not find news with id '.$id_news
               );
         }

         $comments = new \Doctrine\Common\Collections\ArrayCollection();

         $comments = $dm->getRepository('AppBundle:comments')->findAllByNews($news);

         return $this->render('webbb/comments.html.twig',array('comments' => $comments));
     }

}

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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Doctrine\Common\Collections\Collection;

class SubscribeController extends WebbController
{

     /**
     * @Route("/subscribe/m/{id_movie}", name="subscribe_movie")
     */
     public function MovieSubscribe($id_movie, Request $request){
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();

       $movie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

       if (!$movie) {
             throw $this->createNotFoundException(
               'No movie found for id '.$id_movie
             );
       }

       $user = $this->getUser();

       if (!$user) {
             throw $this->createNotFoundException(
               'Not logged in!'
             );
       }

       $user->addMovie($movie);
       $movie->addUser($user);

       $em->persist($user);
       $em->persist($movie);
       $em->flush();

       return $this->redirect($referer);

     }

     /**
     * @Route("/subscribe/t/{id_tvshow}", name="subscribe_tvshow")
     */
     public function TVShowSubscribe($id_tvshow, Request $request){
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();

       $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id_tvshow);

       if (!$tvshow) {
             throw $this->createNotFoundException(
               'No tvshow found for id '.$id_tvshow
             );
       }

       $user = $this->getUser();

       if (!$user) {
             throw $this->createNotFoundException(
               'Not logged in!'
             );
       }

       $user->addTvshow($tvshow);
       $tvshow->addUser($user);

       $em->persist($user);
       $em->persist($tvshow);
       $em->flush();

       return $this->redirect($referer);

     }

     /**
     * @Route("/unsubscribe/m/{id_movie}", name="unsubscribe_movie")
     */
     public function MovieUnsubscribe($id_movie, Request $request){
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();

       $movie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

       if (!$movie) {
             throw $this->createNotFoundException(
               'No movie found for id '.$id_movie
             );
       }

       $user = $this->getUser();

       if (!$user) {
             throw $this->createNotFoundException(
               'Not logged in!'
             );
       }

       $user->removeMovie($movie);
       $movie->removeUser($user);

       $em->persist($user);
       $em->persist($movie);
       $em->flush();

       return $this->redirect($referer);

     }

     /**
     * @Route("/unsubscribe/t/{id_tvshow}", name="unsubscribe_tvshow")
     */
     public function TVShowUnsubscribe($id_tvshow, Request $request){
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();

       $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id_tvshow);

       if (!$tvshow) {
             throw $this->createNotFoundException(
               'No tvshow found for id '.$id_tvshow
             );
       }

       $user = $this->getUser();

       if (!$user) {
             throw $this->createNotFoundException(
               'Not logged in!'
             );
       }

       $user->removeTvshow($tvshow);
       $tvshow->removeUser($user);

       $em->persist($user);
       $em->persist($tvshow);
       $em->flush();
       
       return $this->redirect($referer);

     }

}

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



class MyController extends WebbController
{

    /**
     * @Route("/my-account", name="my-account")
     */
    public function myAccountAction(Request $request)
    {
        // replace this example code with whatever you need
        //here get user
        $user = $this->getUser();
        return $this->render('webbb/my-account.html.twig', array('user' => $user));
    }

    /**
     * @Route("/full-calendar-limit", name="full-calendar-limit")
     */
    public function fullCalendarLimitAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('webbb/my-calendar.html.twig');
    }

    /**
    * @Route("/my-movies", name="my-movies")
    */
    public function myMoviesAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (!$user) {
              throw $this->createNotFoundException(
                'Not logged in!'
              );
        }

        $movies = new \Doctrine\Common\Collections\ArrayCollection();

        $movies = $em->getRepository('AppBundle:movie')->findAllByUser($user);

        $images = array();
         foreach ($movies as $key => $movie) {
           $images[$key] = base64_encode(stream_get_contents($movie->getPicture()));
         }

        return $this->render('webbb/my-movies.html.twig', array('movies' => $movies, 'images' => $images));
    }

    /**
     * @Route("/my-tvshows", name="my-tvshows")
     */
     public function myTVShowsAction()
     {
         $user = $this->getUser();
         $em = $this->getDoctrine()->getManager();

         if (!$user) {
               throw $this->createNotFoundException(
                 'Not logged in!'
               );
         }

         $tvshows = new \Doctrine\Common\Collections\ArrayCollection();

         $tvshows = $em->getRepository('AppBundle:tvshow')->findAllByUser($user);

         $images = array();
          foreach ($tvshows as $key => $tvshow) {
            $images[$key] = base64_encode(stream_get_contents($tvshow->getPicture()));
          }

         //$images = array();
         //$images = base64_encode(stream_get_contents($tvshow->getPicture()));
        // foreach ($tvshow.getPicture() as $key => $entity) {
           //$images[$key] = base64_encode(stream_get_contents($entity->getFoto()));
         //}

         return $this->render('webbb/my-tvshows.html.twig', array('tvshows' => $tvshows, 'images' => $images));
     }

}

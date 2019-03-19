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



class WebbController extends Controller
{

    /**
     * @Route("/", name="index_webb")
     */
    public function indexWebbAction(Request $request)
    {

       /*$tvshow = $this->getDoctrine()->getRepository(tvshow::class)->findAll();
       $images_tvshow = array();
       foreach ($tvshow as $key => $m) {
              $images_tvshow[$key] = base64_encode(stream_get_contents($m->getPicture()));
       }
        $movie = $this->getDoctrine()->getRepository(movie::class)->findAll();
        $images_movie = array();
        foreach ($movie as $key => $m) {
               $images_movie[$key] = base64_encode(stream_get_contents($m->getPicture()));
        }

        $media = new \Doctrine\Common\Collections\ArrayCollection();
        $images = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($tvshow as $t){
            if($t){
              $media->add($t);
            }
        }
        foreach($movie as $t){
            if($t){
              $media->add($t);
            }
        }
        foreach($images_tvshow as $t){
            if($t){
              $images->add($t);
            }
        }
        foreach($images_movie as $t){
            if($t){
              $images->add($t);
            }
        }*/


        $auth_checker = $this->get('security.authorization_checker');
        # e.g: $auth_checker->isGranted('ROLE_ADMIN');

        $token = $this->get('security.token_storage')->getToken();
        # e.g: $token->getUser();
        # e.g: $token->isAuthenticated();
        # [Careful]            ^ "Anonymous users are technically authenticated"

        // Get our user from that token
        //$user = $token->getUser();
        # e.g (w/ FOSUserBundle): $user->getEmail(); $user->isSuperAdmin(); $user->hasRole();

        $isRoleAuthenticated = $auth_checker->isGranted('IS_AUTHENTICATED_REMEMBERED');

        if($isRoleAuthenticated){
          return $this->forward('AppBundle:Newsfeed:newsfeedUser');
        }

        return $this->render('webbb/index.html.twig');
    }

    /**
     * @Route("/movie/{id}", name="movie")
     */
     public function MovieShowAction($id)
     {
         $movie = $this->getDoctrine()
                         ->getRepository(movie::class)
                         ->find($id);

         if (!$movie) {
               throw $this->createNotFoundException(
                 'No movie found for id '.$id
               );
         }

         //$images = array();
         $images = base64_encode(stream_get_contents($movie->getPicture()));
        // foreach ($tvshow.getPicture() as $key => $entity) {
           //$images[$key] = base64_encode(stream_get_contents($entity->getFoto()));
         //}

         return $this->render('webbb/movie.html.twig', array('movie' => $movie, 'image' => $images));
     }

    /**
     * @Route("/tvshow/{id}", name="tvshow")
     */
     public function TVShowShowAction($id)
     {
         $tvshow = $this->getDoctrine()
                         ->getRepository(tvshow::class)
                         ->find($id);

         if (!$tvshow) {
               throw $this->createNotFoundException(
                 'No tvshow found for id '.$id
               );
         }

         //$images = array();
         $images = base64_encode(stream_get_contents($tvshow->getPicture()));
        // foreach ($tvshow.getPicture() as $key => $entity) {
           //$images[$key] = base64_encode(stream_get_contents($entity->getFoto()));
         //}

         return $this->render('webbb/tvshow.html.twig', array('tvshow' => $tvshow, 'image' => $images));
     }


     /**
      * @Route("/full-calendar", name="full-calendar")
      */
     public function fullCalendarAction(Request $request)
     {
         // replace this example code with whatever you need
         return $this->render('webbb/calendar.html.twig');
     }

     /**
     * @Route("/all-movies", name="all-movies")
     */
     public function myMoviesAction()
     {
         $em = $this->getDoctrine()->getManager();

         $movies = new \Doctrine\Common\Collections\ArrayCollection();

         $movies = $em->getRepository('AppBundle:movie')->findAll();

         $images = array();
          foreach ($movies as $key => $movie) {
            $images[$key] = base64_encode(stream_get_contents($movie->getPicture()));
          }

         return $this->render('webbb/all-movies.html.twig', array('movies' => $movies, 'images' => $images));
     }

     /**
      * @Route("/all-tvshows", name="all-tvshows")
      */
      public function myTVShowsAction()
      {
          $em = $this->getDoctrine()->getManager();

          $tvshows = new \Doctrine\Common\Collections\ArrayCollection();

          $tvshows = $em->getRepository('AppBundle:tvshow')->findAll();

          $images = array();
           foreach ($tvshows as $key => $tvshow) {
             $images[$key] = base64_encode(stream_get_contents($tvshow->getPicture()));
           }

          //$images = array();
          //$images = base64_encode(stream_get_contents($tvshow->getPicture()));
         // foreach ($tvshow.getPicture() as $key => $entity) {
            //$images[$key] = base64_encode(stream_get_contents($entity->getFoto()));
          //}

          return $this->render('webbb/all-tvshows.html.twig', array('tvshows' => $tvshows, 'images' => $images));
      }

}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\tvshow;
use AppBundle\Entity\movie;
use AppBundle\Entity\User;
use AppBundle\Entity\news;
use AppBundle\Entity\ratings;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use blackknight467\StarRatingBundle\Form\RatingType as RatingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Doctrine\Common\Collections\Collection;

class RatingsController extends WebbController
{

    /**
    * @Route("/saverating/{id_tvshow}", name="saveRatingTVShow")
    */
     public function saveRatingTVShowAction($id_tvshow, Request $request)
     {

        $request = $this->get('request_stack')->getMasterRequest();
        $referer = $request->headers->get('referer');

        $em = $this->getDoctrine()->getManager();

        $ratingNew = new ratings();

        $user = $this->getUser();

        $form = $this->createFormBuilder($ratingNew)
         ->add('value', RatingType::class, array('label' => 'You didn\'t rate this yet'))
         ->add('submit', SubmitType::class, array('label' => 'Rate now!'))
         ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              $data = $form->getData();

              $ratingNew->setValue($data->getValue());
              $ratingNew->setGivenBy($user);

              $belongsToTVShow = $this->getDoctrine()->getRepository(tvshow::class)->find($id_tvshow);

              if($belongsToTVShow){
                $ratingNew->setBelongsToTVShow($belongsToTVShow);
                $belongsToTVShow->addRating($ratingNew);

                $total = 0;
                foreach ($belongsToTVShow->getRatings() as $r) {
                  $total += $r->getValue();
                }
                $total = $total/($belongsToTVShow->getRatings()->count());

                $belongsToTVShow->setTotalRating($total);
                $em->persist($belongsToTVShow);

                $em->persist($ratingNew);
                $em->flush();

                return $this->redirect($referer);

              }

        }

        return $this->render('webbb/addRating.html.twig', array(
           'form' => $form->createView(),
       ));

     }

     /**
     * @Route("/saveratingMovie/{id_movie}", name="saveRatingMovie")
     */
     public function saveRatingMovieAction($id_movie, Request $request)
     {
       $request = $this->get('request_stack')->getMasterRequest();
       $referer = $request->headers->get('referer');

        $em = $this->getDoctrine()->getManager();

        $ratingNew = new ratings();

        $user = $this->getUser();

        $form = $this->createFormBuilder($ratingNew)
           ->add('value', RatingType::class, array('label' => 'Your rating'))
           ->add('save', SubmitType::class, array('label' => 'Rate this'))
           ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              $data = $form->getData();

              $ratingNew->setValue($data->getValue());
              $ratingNew->setGivenBy($user);

              $belongsToMovie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

              if($belongsToMovie){
                $ratingNew->setBelongsToMovie($belongsToMovie);
                $belongsToMovie->addRating($ratingNew);

                $total = 0;
                foreach ($belongsToMovie->getRatings() as $m) {
                  $total += $m->getValue();
                }
                $total = $total/($belongsToMovie->getRatings()->count());

                $belongsToMovie->setTotalRating($total);

                $em->persist($belongsToMovie);

                $em->persist($ratingNew);
                $em->flush();

                return $this->redirect($referer)->redirectResponse($referer);

              }

        }

        return $this->render('webbb/addRating.html.twig', array(
           'form' => $form->createView(),
       ));

     }

     /**
     * @Route("/saveratingEpisode/{id_episode}", name="saveRatingEpisode")
     */
      public function saveRatingEpisodeAction($id_episode)
      {

         $request = $this->get('request_stack')->getMasterRequest();
         $referer = $request->headers->get('referer');

         $em = $this->getDoctrine()->getManager();

         $ratingNew = new ratings();

         $user = $this->getUser();

         $form = $this->createFormBuilder($ratingNew)
          ->add('value', RatingType::class, array('label' => 'Your rating'))
          ->add('submit', SubmitType::class, array('label' => 'Rate this'))
          ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
               $data = $form->getData();

               $ratingNew->setValue($data->getValue());
               $ratingNew->setGivenBy($user);

               $belongsToEpisode = $this->getDoctrine()->getRepository(episodes::class)->find($id_episode);

               if($belongsToEpisode){
                 $ratingNew->setBelongsToTVShow($belongsToEpisode);
                 $belongsToEpisode->addRating($ratingNew);

                 $total = 0;
                 foreach ($belongsToEpisode->getRatings() as $r) {
                   $total += $r->getValue();
                 }
                 $total = $total/($belongsToEpisode->getRatings()->count());

                 $belongsToEpisode->setTotalRating($total);
                 $em->persist($belongsToEpisode);

                 $em->persist($ratingNew);
                 $em->flush();

                 return $this->redirect($referer, 302, array('id' => $id_episode));

               }

         }

         return $this->render('webbb/addRating.html.twig', array(
            'form' => $form->createView(),
        ));

      }

     /**
      * @Route("/deleterating/{id_rating}", name="deleterating")
      */
     public function deleteRatingAction($id_rating, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $em = $this->getDoctrine()->getManager();
        $rating = $this->getDoctrine()->getRepository(ratings::class)->find($id_rating);

        if (!$rating) {
              throw $this->createNotFoundException(
                'No rating found for id '.$id_rating
              );
        }

        $em->remove($rating);
        $em->flush();

        return $this->redirect($referer);

     }

}

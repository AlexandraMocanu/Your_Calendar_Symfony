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
use AppBundle\Entity\episodes;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Doctrine\Common\Collections\Collection;



class EpisodesController extends WebbController
{

     /**
      * @Route("/addepisode/{id}", name="addepisode")
      * id belongs to a tvshow
      */
     public function addEpisodeAction($id, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $episode = new episodes();

        $form = $this->createFormBuilder($episode)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('number_in_tvshow', IntegerType::class)
            ->add('season', IntegerType::class)
            ->add('number_in_season', IntegerType::class)
            ->add('premiere', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create episode'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              // $form->getData() holds the submitted values
              $data = $form->getData();

              // set the fields that don't depend on user input
              $em = $this->getDoctrine()->getManager();

              $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id);

              if (!$tvshow) {
                    throw $this->createNotFoundException(
                      'No tvshow found for id '.$id
                    );
              }
              $episode->setBelongsToTVShow($tvshow);

              $episode->setTotalRating(null);

              //persist the rest of the data from the form
              $em->persist($data);
              $em->flush();

              return $this->redirect($referer);

         }

         return $this->render('webbb/addepisode.html.twig', array(
            'form' => $form->createView(),
        ));

     }

     /**
      * @Route("/deleteepisode/{id_episode}", name="deleteepisode")
      */
     public function deleteEpisodeAction($id_episode, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $em = $this->getDoctrine()->getManager();
        $episode = $this->getDoctrine()->getRepository(episodes::class)->find($id_episode);

        if (!$episode) {
              throw $this->createNotFoundException(
                'No episode found for id '.$id_episode
              );
        }


        $em->remove($episode);
        $em->flush();

        return $this->redirect($referer);

     }

     /**
      * @Route("/updateepisode/{id_episode}", name="updateepisode")
      */
     public function UpdateEpisodeAction($id_episode, Request $request)
     {
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();
       $episode = $this->getDoctrine()->getRepository(episodes::class)->find($id_episode);

       if (!$episode) {
             throw $this->createNotFoundException(
               'No episode found for id '.$id_episode
             );
       }

       $newepisode = new episodes();

       $form = $this->createFormBuilder($newepisode)
           ->add('name', TextType::class, array('data' => $episode->getName()))
           ->add('description', TextType::class, array('data' => $episode->getDescription()))
           ->add('number_in_tvshow', IntegerType::class, array('data' => $episode->getNumberInTvshow()))
           ->add('season', IntegerType::class, array('data' => $episode->getSeason()))
           ->add('number_in_season', IntegerType::class, array('data' => $episode->getNumberInSeason()))
           ->add('premiere', DateType::class, array('data' => $episode->getPremiere()))
           ->add('save', SubmitType::class, array('label' => 'Update Episode'))
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             $data = $form->getData();

             $em = $this->getDoctrine()->getManager();

             $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($episode->getBelongsToTVShow()->getId());
             if (!$tvshow) {
                   throw $this->createNotFoundException(
                     'No tvshow found for id '.$id
                   );
             }
             $episode->setBelongsToTVShow($tvshow);

             $episode->setName($data->getName());
             $episode->setDescription($data->getDescription());
             $episode->setNumberInTvshow($data->getNumberInTvshow());
             $episode->setSeason($data->getSeason());
             $episode->setNumberInSeason($data->getNumberInSeason());
             $episode->setPremiere($data->getPremiere());
             $episode->setTotalRating($episode->getTotalRating());
             //persist the rest of the data from the form

             $em->persist($episode);
             $em->flush();
             $em->remove($newepisode);
             $em->flush();

             return $this->redirect($referer);

        }

        return $this->render('webbb/updateEpisode.html.twig', array(
           'form' => $form->createView(),
       ));

     }

     /**
      * @Route("/episodes/byTVShow_{id}", name="episodes_by_tvshow")
      */
     public function episodesTVShowAction($id)
     {
         $em = $this->getDoctrine()->getManager();

         $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id);
         if (!$tvshow) {
               throw $this->createNotFoundException(
                 'No tvshow found for id '.$id
               );
         }

         $episodes = new \Doctrine\Common\Collections\ArrayCollection();

         $episodes = $em->getRepository('AppBundle:episodes')->findAllByTVShow($tvshow);

         return $this->render('webbb/tvshow_episodes.html.twig',array('episodes' => $episodes, 'tvshow' => $tvshow));
     }

     /**
      * @Route("/episode/{id}", name="episode")
      */
     public function episodeAction($id)
     {
         $em = $this->getDoctrine()->getManager();

         $episode = $this->getDoctrine()->getRepository(episodes::class)->find($id);
         if (!$episode) {
               throw $this->createNotFoundException(
                 'No episode found for id '.$id
               );
         }

        $images = base64_encode(stream_get_contents($episode->getBelongsToTVShow()->getPicture()));

         return $this->render('webbb/episode.html.twig',array('episode' => $episode, 'image' => $images));
     }

}

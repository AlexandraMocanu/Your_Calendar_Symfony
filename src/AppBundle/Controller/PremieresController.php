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
use AppBundle\Entity\premieres;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Doctrine\Common\Collections\Collection;



class PremieresController extends WebbController
{

     /**
      * @Route("/addpremiere/{id}", name="addpremiere")
      * id belongs to a movie
      */
     public function addPremiereAction($id, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $premiere = new premieres();

        $form = $this->createFormBuilder($premiere)
            ->add('country', TextType::class)
            ->add('date', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create episode'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              // $form->getData() holds the submitted values
              $data = $form->getData();

              // set the fields that don't depend on user input
              $em = $this->getDoctrine()->getManager();

              $movie = $this->getDoctrine()->getRepository(movie::class)->find($id);

              if (!$movie) {
                    throw $this->createNotFoundException(
                      'No movie found for id '.$id
                    );
              }
              $premiere->setBelongsToMovie($movie);

              //persist the rest of the data from the form
              $em->persist($data);
              $em->flush();

              return $this->redirect($referer);

         }

         return $this->render('webbb/addpremiere.html.twig', array(
            'form' => $form->createView(),
        ));

     }

     /**
      * @Route("/deletepremiere/{id_premiere}", name="deletepremiere")
      */
     public function deletePremiereAction($id_premiere, Request $request)
     {
        $referer = $request->headers->get('referer');

        // create a task and give it some dummy data for this example
        $em = $this->getDoctrine()->getManager();
        $premiere = $this->getDoctrine()->getRepository(premieres::class)->find($id_premiere);

        if (!$premiere) {
              throw $this->createNotFoundException(
                'No premiere found for id '.$id_premiere
              );
        }


        $em->remove($premiere);
        $em->flush();

        return $this->redirect($referer);

     }

     /**
      * @Route("/updatepremiere/{id_premiere}", name="updatepremiere")
      */
     public function UpdatePremiereAction($id_premiere, Request $request)
     {
       $referer = $request->headers->get('referer');

       $em = $this->getDoctrine()->getManager();
       $premiere = $this->getDoctrine()->getRepository(premieres::class)->find($id_premiere);

       if (!$premiere) {
             throw $this->createNotFoundException(
               'No premiere found for id '.$id_premiere
             );
       }

       $newpremiere = new premieres();

       $form = $this->createFormBuilder($newpremiere)
           ->add('country', TextType::class, array('data' => $premiere->getCountry()))
           ->add('date', DateType::class, array('data' => $premiere->getDate()))
           ->add('save', SubmitType::class, array('label' => 'Update Premiere'))
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             $data = $form->getData();

             $em = $this->getDoctrine()->getManager();

             $movie = $this->getDoctrine()->getRepository(movie::class)->find($premiere->getBelongsToMovie()->getId());
             if (!$movie) {
                   throw $this->createNotFoundException(
                     'No movie found for id '.$id
                   );
             }
             $premiere->setBelongsToMovie($movie);

             $premiere->setCountry($data->getCountry());
             $premiere->setDate($data->getDate());
             //persist the rest of the data from the form

             $em->persist($premiere);
             $em->flush();
             $em->remove($newpremiere);
             $em->flush();

             return $this->redirect($referer);

        }

        return $this->render('webbb/updatePremiere.html.twig', array(
           'form' => $form->createView(),
       ));

     }

     /**
      * @Route("/premieres/{id_movie}", name="premieresmovie")
      */
     public function premieresMovieAction($id_movie, Request $request)
     {

         $dm = $this->getDoctrine()->getManager();
         $movie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

         if (!$movie) {
               throw $this->createNotFoundException(
                 'Could not find movie with id '.$id_movie
               );
         }

         $premieres = new \Doctrine\Common\Collections\ArrayCollection();

         $premieres = $dm->getRepository('AppBundle:premieres')->findAllByMovie($movie);

         return $this->render('webbb/premieres.html.twig',array('premieres' => $premieres));
     }

     /**
      * @Route("/premiere/{id_premiere}", name="premiere")
      */
     public function premiereAction($id_premiere, Request $request)
     {

         $dm = $this->getDoctrine()->getManager();
         $premiere = $this->getDoctrine()->getRepository(premieres::class)->find($id_premiere);

         if (!$premiere) {
               throw $this->createNotFoundException(
                 'Could not find premiere with id '.$id_premiere
               );
         }

         $images = base64_encode(stream_get_contents($premiere->getBelongsToMovie()->getPicture()));

         return $this->render('webbb/premiere.html.twig',array('premiere' => $premiere, 'image' => $images));
     }

}

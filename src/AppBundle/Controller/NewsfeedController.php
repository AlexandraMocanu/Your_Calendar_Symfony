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



class NewsfeedController extends WebbController
{
    /**
     * @Route("/addnews", name="addnews")
     */
    public function addNewsAction(Request $request)
    {
       $referer = $request->headers->get('referer');

       // create a task and give it some dummy data for this example
       $news = new news();

       $form = $this->createFormBuilder($news)
           ->add('title', TextType::class)
           ->add('description', TextType::class)
           ->add('publish_date', DateType::class)
           ->add('the_news', TextType::class)
           ->add('main_picture', FileType::class, array('label' => 'Main Picture'))
           ->add('tvshows', EntityType::class, array(
            'class' => 'AppBundle:tvshow',
            'attr'=> array('class' => 'select2'),
            'multiple' => true))
           ->add('movies', EntityType::class, array(
            'class' => 'AppBundle:movie',
            'attr'=> array('class'=> 'select2'),
            'multiple' => true))
           ->add('save', SubmitType::class, array('label' => 'Create News'))
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
             $data = $form->getData();

             $em = $this->getDoctrine()->getManager();

             foreach ($news->getTvshows() as $tvshow) {
               $tvshow->addNews($news);
               $em->persist($tvshow);
             }
             foreach ($news->getMovies() as $movie) {
               $movie->addNews($news);
               $em->persist($movie);
             }

             $em->persist($data);
             $em->flush();

             return $this->redirect($referer);

        }

        return $this->render('webbb/addnews.html.twig', array(
           'form' => $form->createView(),
       ));

    }

    /**
     * @Route("/deletenews/{id_news}", name="deletenews")
     */
    public function deleteNewsAction($id_news, Request $request)
    {
       $referer = $request->headers->get('referer');

       // create a task and give it some dummy data for this example
       $em = $this->getDoctrine()->getManager();
       $news = $this->getDoctrine()->getRepository(news::class)->find($id_news);

       if (!$news) {
             throw $this->createNotFoundException(
               'No news found for id '.$id_news
             );
       }


       $em->remove($news);
       $em->flush();

       return $this->redirect($referer);

    }

    /**
     * @Route("/updatenews/{id_news}", name="updatenews")
     */
    public function UpdateNewsAction($id_news, Request $request)
    {
        $referer = $request->headers->get('referer');

        $em = $this->getDoctrine()->getManager();
        $news = $this->getDoctrine()->getRepository(news::class)->find($id_news);

        if (!$news) {
              throw $this->createNotFoundException(
                'No news found for id '.$id_news
              );
        }

        $newnews = new news();

        $form = $this->createFormBuilder($newnews)
           ->add('title', TextType::class, array('data' => $news->getTitle()))
           ->add('description', TextType::class, array('data' => $news->getDescription()))
           ->add('publish_date', DateType::class, array('data' => $news->getPublishDate()))
           ->add('the_news', TextType::class, array('data' => $news->getTheNews()))
           ->add('main_picture', FileType::class, array('label' => 'Main Picture'))
           ->add('tvshows', EntityType::class, array(
            'class' => 'AppBundle:tvshow',
            'attr'=> array('class' => 'select2'),
            'multiple' => true, 'data' => $news->getTvshows()))
           ->add('movies', EntityType::class, array(
            'class' => 'AppBundle:movie',
            'attr'=> array('class'=> 'select2'),
            'multiple' => true, 'data' => $news->getMovies()))
           ->add('save', SubmitType::class, array('label' => 'Update News'))
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
             $data = $form->getData();

             $em = $this->getDoctrine()->getManager();

             $news->setTitle($data->getTitle());
             $news->setDescription($data->getDescription());
             $news->setPublishDate(new \DateTime('now'));
             $news->setTheNews($data->getTheNews());
             //$news->addTvshow($data->getTvshows());
             //$news->addMovie($data->getMovies());

             foreach ($data->getTvshows() as $tvshow) {
                 if(!$news->getTvshows()->contains($tvshow)){
                   $news->addTvshow($tvshow);
                 }
             }
             foreach ($data->getMovies() as $movie) {
               if(!$news->getMovies()->contains($movie)){
                 $news->addMovie($movie);
               }
             }

             foreach ($news->getTvshows() as $tvshow) {
               if(!$tvshow->getNews()->contains($news)){
                 $tvshow->addNews($news);
                 $em->persist($tvshow);
               }
             }
             foreach ($news->getMovies() as $movie) {
               if(!$movie->getNews()->contains($news)){
                 $movie->addNews($news);
                 $em->persist($movie);
               }
             }

             $em->persist($news);
             $em->flush();
             $em->remove($newnews);
             $em->flush();

             return $this->redirect($referer);

        }

        return $this->render('webbb/updatenews.html.twig', array(
           'form' => $form->createView(),
       ));

    }

    /**
     * @Route("/newsfeed/all", name="newsfeed_all")
     */
    public function newsfeedAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $news = $dm->getRepository('AppBundle:news')->findAll();

        return $this->render('webbb/newsfeed.html.twig',array('news' => $news));
    }

    /**
     * @Route("/newsfeed/", name="newsfeed_by_user")
     */
    public function newsfeedUserAction()
    {
        $dm = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if (!$user) {
              throw $this->createNotFoundException(
                'Not logged in!'
              );
        }

        $tvshows = $user->getTvshows();
        $movies = $user->getMovies(); //user has tvshows and movies
        //tvshows and movies have news

        $news1 = new \Doctrine\Common\Collections\ArrayCollection();
        $news2 = new \Doctrine\Common\Collections\ArrayCollection();
        $news = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($tvshows as $tvshow) {// for every tvshow search the news

          $news1 = $dm->getRepository('AppBundle:news')->findAllByTVShow($tvshow);
          foreach($news1 as $e){
            if(!$news->contains($e)){
              $news->add($e);
            }
          }

        }
        foreach ($movies as $movie) {

          $news2 = $dm->getRepository('AppBundle:news')->findAllByMovie($movie);
          foreach($news2 as $e){
              if(!$news->contains($e)){
                $news->add($e);
              }
          }

        }
        //foreach ($movies as $movie) {
          //$news[] = $dm->getRepository('AppBundle\Entity\news')->findAllByMovie(array('movies' => $movies));
        //}

        //$news = new \Doctrine\Common\Collections\ArrayCollection(array_merge($news1, $news2));
        //$news = $news->toArray();

        return $this->render('webbb/newsfeed.html.twig',array('news' => $news));
    }

    /**
     * @Route("/newsfeed/t/{id_tvshow}", name="newsfeed_by_tvshow", defaults={"max"=null})
     */
    public function newsfeedTVShowAction($id_tvshow, $max)
    {

        $em = $this->getDoctrine()->getManager();

        $tvshow = $this->getDoctrine()->getRepository(tvshow::class)->find($id_tvshow);

        if (!$tvshow) {
              throw $this->createNotFoundException(
                'No tvshow found for id '.$id_tvshow
              );
        }

        $news1 = new \Doctrine\Common\Collections\ArrayCollection();
        $news = new \Doctrine\Common\Collections\ArrayCollection();

        $news1 = $em->getRepository('AppBundle:news')->findAllByTVShow($tvshow);

        foreach($news1 as $e){
          if(!$news->contains($e)){
            $news->add($e);
          }
        }

        if($max != null){
          for($max; $max > 1; $max--){
            $news->remove($max);
          }
          return $this->render('webbb/newsfeedlimit.html.twig',array('news' => $news));
        }


        return $this->render('webbb/newsfeed.html.twig',array('news' => $news));
    }

    /**
     * @Route("/newsfeed/m/{id_movie}", name="newsfeed_by_movie", defaults={"max"=null})
     */
    public function newsfeedMovieAction($id_movie, $max)
    {
      $em = $this->getDoctrine()->getManager();

      $movie = $this->getDoctrine()->getRepository(movie::class)->find($id_movie);

      if (!$movie) {
            throw $this->createNotFoundException(
              'No movie found for id '.$id_movie
            );
      }

      $news1 = new \Doctrine\Common\Collections\ArrayCollection();
      $news = new \Doctrine\Common\Collections\ArrayCollection();

      $news1 = $em->getRepository('AppBundle:news')->findAllByTVShow($movie);
      foreach($news1 as $e){
        if(!$news->contains($e)){
          $news->add($e);
        }
      }

      if($max != null){
        for($max; $max > 1; $max--){
          $news->remove($max);
        }
        return $this->render('webbb/newsfeedlimit.html.twig',array('news' => $news));
      }

      return $this->render('webbb/newsfeed.html.twig',array('news' => $news));
    }

    /**
     * @Route("/newsfeed/news/{id_news}", name="news")
     */
    public function newsAction($id_news)
    {
      $em = $this->getDoctrine()->getManager();

      $news = $this->getDoctrine()->getRepository(news::class)->find($id_news);

      if (!$news) {
            throw $this->createNotFoundException(
              'No news found for id '.$id_news
            );
      }

      $images = base64_encode(stream_get_contents($news->getMainPicture()));

      return $this->render('webbb/news.html.twig',array('news' => $news, 'images' => $images));
    }

}

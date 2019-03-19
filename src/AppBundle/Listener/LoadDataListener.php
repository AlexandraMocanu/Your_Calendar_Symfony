<?php
namespace AppBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AppBundle\Entity\episodes;
use AppBundle\Entity\premieres;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Model\User;
use \Doctrine\Common\Collections\Collection;

class LoadDataListener
{
    /**
     * @var EntityManager
     */
    private $em;

    private $tokenStorage;

    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $repository = $this->em->getRepository('AppBundle:episodes');
        $episodes = $repository->findAll();

        /** @var episodes $episode */
        foreach ($episodes as $episode) {

            //string concat => .
            $episode_short = $episode->getBelongsToTVShow()->getName() . "  S" . $episode->getSeason() . "E" . $episode->getNumberInSeason();

            //addevent -> title, start; title = episode_short; start = premiere;
            $event = new Event($episode_short, $episode->getPremiere());

            //addcustomfield -> episode title
            $event->setCustomField('episode_title', $episode->getName());

            $event->setCustomField('tvshow_name', $episode->getBelongsToTVShow()->getName());

            $link = "/" . "tvshow/" . $episode->getBelongsToTVShow()->getId();
            $event->setCustomField('lk', $link);

            $calendarEvent->addEvent($event);

        }

        $repository = $this->em->getRepository('AppBundle:premieres');
        $premieres = $repository->findAll();
        // You may want to add an Event into the Calendar view.

        /** @var premieres $premiere */
        foreach ($premieres as $premiere) {

            //addevent -> title, start; title = movie title; start = premiere;
            $event = new Event($premiere->getBelongsToMovie()->getName(), $premiere->getDate());

            //addcustomfield -> country premiere
            $event->setCustomField('premiere_countries', $premiere->getCountry());

            $event->setCustomField('movie_name', $premiere->getBelongsToMovie()->getName());

            $link = "/" . "movie/" . $premiere->getBelongsToMovie()->getId();
            $event->setCustomField('lk', $link);

            $calendarEvent->addEvent($event);
        }
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadDataLimit(CalendarEvent $calendarEvent)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $episodes = new \Doctrine\Common\Collections\ArrayCollection();
        if($user == null){
          $repository = $this->em->getRepository('AppBundle:episodes');
          $episodes = $repository->findAll();
        }else{
          $repository = $this->em->getRepository('AppBundle:tvshow');
          $tvshows = $repository->findAllByUser($user);
          $repository = $this->em->getRepository('AppBundle:episodes');
          foreach ($tvshows as $tvshow) {
            $episode = $repository->findAllByTVShow($tvshow);
            foreach ($episode as $e) {
              $episodes->add($e);
            }
          }
        }


        /** @var episodes $episode */
        foreach ($episodes as $episode) {

            //string concat => .
            $episode_short = $episode->getBelongsToTVShow()->getName() . "  S" . $episode->getSeason() . "E" . $episode->getNumberInSeason();

            //addevent -> title, start; title = episode_short; start = premiere;
            $event = new Event($episode_short, $episode->getPremiere());

            //addcustomfield -> episode title
            $event->setCustomField('episode_title', $episode->getName());

            $event->setCustomField('tvshow_name', $episode->getBelongsToTVShow()->getName());

            $link = "/" . "tvshow/" . $episode->getBelongsToTVShow()->getId();
            $event->setCustomField('lk', $link);

            $calendarEvent->addEvent($event);

        }

        $premieres = new \Doctrine\Common\Collections\ArrayCollection();
        if($user == null){
          $repository = $this->em->getRepository('AppBundle:premieres');
          $premieres = $repository->findAll();
        }else{
          $repository = $this->em->getRepository('AppBundle:movie');
          $movies = $repository->findAllByUser($user);
          $repository = $this->em->getRepository('AppBundle:premieres');
          foreach ($movies as $movie) {
            $premiere = $repository->findAllByMovie($movie);
            foreach ($premiere as $p) {
              $premieres->add($p);
            }
          }
        }

        /** @var premieres $premiere */
        foreach ($premieres as $premiere) {

            //addevent -> title, start; title = movie title; start = premiere;
            $event = new Event($premiere->getBelongsToMovie()->getName(), $premiere->getDate());

            //addcustomfield -> country premiere
            $event->setCustomField('premiere_countries', $premiere->getCountry());

            $event->setCustomField('movie_name', $premiere->getBelongsToMovie()->getName());

            $link = "/" . "movie/" . $premiere->getBelongsToMovie()->getId();
            $event->setCustomField('lk', $link);

            $calendarEvent->addEvent($event);
        }
      }

}

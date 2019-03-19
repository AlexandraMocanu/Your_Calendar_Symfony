<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\news;
use \Doctrine\Common\Collections\Collection;

class NewsRepository extends EntityRepository
{
    public function findAllByTVShow($tvshow)
    {
        $em = $this->getEntityManager();

        $newsintvshow = $em->getRepository("AppBundle:news")
                           ->createQueryBuilder('o') //o alias news entity
                           ->innerJoin('o.tvshows', 't')
                           ->where('t.id = :tvshow_id')
                           ->setParameter('tvshow_id', $tvshow->getId())
                           ->getQuery()->getResult();

        return $newsintvshow;
    }

    public function findAllByMovie($movie)
    {
        $em = $this->getEntityManager();

        $newsinmovie = $em->getRepository("AppBundle:news")
                           ->createQueryBuilder('o') //o alias news entity
                           ->innerJoin('o.movies', 't')
                           ->where('t.id = :movie_id')
                           ->setParameter('movie_id', $movie->getId())
                           ->getQuery()->getResult();

        return $newsinmovie;

        /*$em = $this->getEntityManager();

        $query = $em->createQuery("SELECT s FROM AppBundle:news s LEFT JOIN s.tvshows a");
        /*$queryText  = "SELECT s , a FROM AppBundle:news s JOIN s.movies a";
        $queryText .= "WHERE :movie MEMBER OF a.movies";

        $query = $em->createQuery($queryText);
        $query->setParameter('movies', $movie);*/

        //return $query->getResult();

    }
  }

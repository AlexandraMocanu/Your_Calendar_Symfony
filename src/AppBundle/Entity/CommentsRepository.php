<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\comments;
use \Doctrine\Common\Collections\Collection;

class CommentsRepository extends EntityRepository
{
      public function findAllByUser($user)
      {
          $em = $this->getEntityManager();

          $comments = $em->getRepository("AppBundle:comments")
                             ->createQueryBuilder('o') //o alias comments entity
                             ->innerJoin('o.user', 't')
                             ->where('t.id = :user_id')
                             ->setParameter('user_id', $user->getId())
                             ->getQuery()->getResult();

          return $comments;
      }

      public function findAllByTVShow($tvshow)
      {
          $em = $this->getEntityManager();

          $comments = $em->getRepository("AppBundle:comments")
                             ->createQueryBuilder('o') //o alias comments entity
                             ->innerJoin('o.belongsToTVShow', 't')
                             ->where('t.id = :tvshow_id')
                             ->setParameter('tvshow_id', $tvshow->getId())
                             ->getQuery()->getResult();

          return $comments;
      }

      public function findAllByMovie($movie)
      {
          $em = $this->getEntityManager();

          $comments = $em->getRepository("AppBundle:comments")
                             ->createQueryBuilder('o') //o alias comments entity
                             ->innerJoin('o.belongsToMovie', 't')
                             ->where('t.id = :movie_id')
                             ->setParameter('movie_id', $movie->getId())
                             ->getQuery()->getResult();

          return $comments;
      }

      public function findAllByNews($news)
      {
          $em = $this->getEntityManager();

          $comments = $em->getRepository("AppBundle:comments")
                             ->createQueryBuilder('o') //o alias comments entity
                             ->innerJoin('o.belongsToNews', 't')
                             ->where('t.id = :news_id')
                             ->setParameter('news_id', $news->getId())
                             ->getQuery()->getResult();

          return $comments;
      }

  }

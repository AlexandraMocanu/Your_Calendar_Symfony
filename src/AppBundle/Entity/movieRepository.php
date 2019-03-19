<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\movie;
use \Doctrine\Common\Collections\Collection;

class movieRepository extends EntityRepository
{

      public function findAllByUser($user)
      {
          $em = $this->getEntityManager();

          $movies = $em->getRepository("AppBundle:movie")
                             ->createQueryBuilder('o') //o alias tvshows entity
                             ->innerJoin('o.users', 't')
                             ->where('t.id = :user_id')
                             ->setParameter('user_id', $user->getId())
                             ->getQuery()->getResult();

          return $movies;
      }

  }

<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\tvshow;
use \Doctrine\Common\Collections\Collection;

class tvshowRepository extends EntityRepository
{

      public function findAllByUser($user)
      {
          $em = $this->getEntityManager();

          $tvshows = $em->getRepository("AppBundle:tvshow")
                             ->createQueryBuilder('o') //o alias tvshows entity
                             ->innerJoin('o.users', 't')
                             ->where('t.id = :user_id')
                             ->setParameter('user_id', $user->getId())
                             ->getQuery()->getResult();

          return $tvshows;
      }

  }

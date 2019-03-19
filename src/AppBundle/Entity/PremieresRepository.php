<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\premieres;
use \Doctrine\Common\Collections\Collection;

class PremieresRepository extends EntityRepository
{

      public function findAllByMovie($movie)
      {
          $em = $this->getEntityManager();

          $premieres = $em->getRepository("AppBundle:premieres")
                             ->createQueryBuilder('o') //o alias comments entity
                             ->innerJoin('o.belongsToMovie', 't')
                             ->where('t.id = :movie_id')
                             ->setParameter('movie_id', $movie->getId())
                             ->getQuery()->getResult();

          return $premieres;
      }

  }

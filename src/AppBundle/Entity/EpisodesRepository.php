<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\episodes;
use \Doctrine\Common\Collections\Collection;

class EpisodesRepository extends EntityRepository
{

      public function findAllByTVShow($tvshow)
      {
          $em = $this->getEntityManager();

          $episodes = $em->getRepository("AppBundle:episodes")
                             ->createQueryBuilder('o') //o alias episodes entity
                             ->innerJoin('o.belongsToTVShow', 't')
                             ->where('t.id = :tvshow_id')
                             ->setParameter('tvshow_id', $tvshow->getId())
                             ->getQuery()->getResult();

          return $episodes;
      }

  }

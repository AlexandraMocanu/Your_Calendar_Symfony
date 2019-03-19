<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ratings")
 */

class ratings{

     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
      private $id;

      /**
      * @ORM\Column(type="float")
      * value given by a user
      */
      private $value;

      /**
      * @ORM\ManyToOne(targetEntity="User", inversedBy="ratingsGiven", cascade={"persist"})
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $givenBy;

      /**
      * One rating is for one tvshow
      * @ORM\ManyToOne(targetEntity="tvshow", inversedBy="ratings", cascade={"persist"})
      * @ORM\JoinColumn(name="tvshow_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToTVShow;

      /**
      * One rating is for one movie
      * @ORM\ManyToOne(targetEntity="movie", inversedBy="ratings", cascade={"persist"})
      * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToMovie;

      /**
      * One rating is for one episode
      * @ORM\ManyToOne(targetEntity="episodes", inversedBy="ratings", cascade={"persist"})
      * @ORM\JoinColumn(name="episode_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToEpisode;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return ratings
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set givenBy
     *
     * @param \AppBundle\Entity\User $givenBy
     *
     * @return ratings
     */
    public function setGivenBy(\AppBundle\Entity\User $givenBy = null)
    {
        $this->givenBy = $givenBy;

        return $this;
    }

    /**
     * Get givenBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getGivenBy()
    {
        return $this->givenBy;
    }

    /**
     * Set belongsToTVShow
     *
     * @param \AppBundle\Entity\tvshow $belongsToTVShow
     *
     * @return ratings
     */
    public function setBelongsToTVShow(\AppBundle\Entity\tvshow $belongsToTVShow = null)
    {
        $this->belongsToTVShow = $belongsToTVShow;

        return $this;
    }

    /**
     * Get belongsToTVShow
     *
     * @return \AppBundle\Entity\tvshow
     */
    public function getBelongsToTVShow()
    {
        return $this->belongsToTVShow;
    }

    /**
     * Set belongsToMovie
     *
     * @param \AppBundle\Entity\movie $belongsToMovie
     *
     * @return ratings
     */
    public function setBelongsToMovie(\AppBundle\Entity\movie $belongsToMovie = null)
    {
        $this->belongsToMovie = $belongsToMovie;

        return $this;
    }

    /**
     * Get belongsToMovie
     *
     * @return \AppBundle\Entity\movie
     */
    public function getBelongsToMovie()
    {
        return $this->belongsToMovie;
    }

    /**
     * Set belongsToEpisode
     *
     * @param \AppBundle\Entity\episodes $belongsToEpisode
     *
     * @return ratings
     */
    public function setBelongsToEpisode(\AppBundle\Entity\episodes $belongsToEpisode = null)
    {
        $this->belongsToEpisode = $belongsToEpisode;

        return $this;
    }

    /**
     * Get belongsToEpisode
     *
     * @return \AppBundle\Entity\episodes
     */
    public function getBelongsToEpisode()
    {
        return $this->belongsToEpisode;
    }
}

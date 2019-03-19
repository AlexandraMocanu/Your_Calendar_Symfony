<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PremieresRepository")
 * @ORM\Table(name="premieres")
 */

class premieres
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

    /**
    * One premiere is for one tvshow
    * @ORM\ManyToOne(targetEntity="movie", inversedBy="premieres", cascade={"persist"})
    * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
    */
    private $belongsToMovie;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $country;



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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return premieres
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return premieres
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set belongsToMovie
     *
     * @param \AppBundle\Entity\movie $belongsToMovie
     *
     * @return premieres
     */
    public function setBelongsToMovie(\AppBundle\Entity\movie $belongsToMovie)
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
}

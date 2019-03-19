<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EpisodesRepository")
 * @ORM\Table(name="episodes")
 */

class episodes
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

    /**
    * One episode is for one tvshow
    * @ORM\ManyToOne(targetEntity="tvshow", inversedBy="episodes", cascade={"persist"})
    * @ORM\JoinColumn(name="tvshow_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
    */
    private $belongsToTVShow;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_in_tvshow;

    /**
     * @ORM\Column(type="integer")
     */
    private $season;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_in_season;

    /**
     * @ORM\Column(type="datetime")
     */
    private $premiere;

    /**
    *One episode has many ratings given
    *@var \Doctrine\Common\Collections\ArrayCollection
    *@ORM\OneToMany(targetEntity="ratings", mappedBy="belongsToEpisode", cascade={"persist"})
    */
    private $ratings;

    /**
    *@ORM\Column(type="float", nullable=true)
    */
    private $totalRating;

    public function __construct() {
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return episodes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return episodes
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set numberInTvshow
     *
     * @param integer $numberInTvshow
     *
     * @return episodes
     */
    public function setNumberInTvshow($numberInTvshow)
    {
        $this->number_in_tvshow = $numberInTvshow;

        return $this;
    }

    /**
     * Get numberInTvshow
     *
     * @return integer
     */
    public function getNumberInTvshow()
    {
        return $this->number_in_tvshow;
    }

    /**
     * Set season
     *
     * @param integer $season
     *
     * @return episodes
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return integer
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set numberInSeason
     *
     * @param integer $numberInSeason
     *
     * @return episodes
     */
    public function setNumberInSeason($numberInSeason)
    {
        $this->number_in_season = $numberInSeason;

        return $this;
    }

    /**
     * Get numberInSeason
     *
     * @return integer
     */
    public function getNumberInSeason()
    {
        return $this->number_in_season;
    }

    /**
     * Set totalRating
     *
     * @param float $totalRating
     *
     * @return episodes
     */
    public function setTotalRating($totalRating)
    {
        $this->totalRating = $totalRating;

        return $this;
    }

    /**
     * Get totalRating
     *
     * @return float
     */
    public function getTotalRating()
    {
        return $this->totalRating;
    }

    /**
     * Set belongsToTVShow
     *
     * @param \AppBundle\Entity\tvshow $belongsToTVShow
     *
     * @return episodes
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
     * Add rating
     *
     * @param \AppBundle\Entity\ratings $rating
     *
     * @return episodes
     */
    public function addRating(\AppBundle\Entity\ratings $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \AppBundle\Entity\ratings $rating
     */
    public function removeRating(\AppBundle\Entity\ratings $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Set premiere
     *
     * @param \DateTime $premiere
     *
     * @return episodes
     */
    public function setPremiere($premiere)
    {
        $this->premiere = $premiere;

        return $this;
    }

    /**
     * Get premiere
     *
     * @return \DateTime
     */
    public function getPremiere()
    {
        return $this->premiere;
    }
}

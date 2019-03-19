<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\tvshowRepository")
 * @ORM\Table(name="tvshow")
 */

class tvshow
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $premiere;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     */
    private $genre;

    /**
     * @ORM\Column(type="text")
     */
    private $airson;

    /**
     * @ORM\Column(type="text")
     */
    private $runtime;

    /**
     * @ORM\Column(type="text")
     */
    private $status;

    /**
     * @ORM\Column(type="text")
     */
    private $createdby;

    /**
     * @ORM\Column(type="text")
     */
    private $imdb;

    /**
     * @ORM\Column(type="text")
     */
    private $tvcom;

    /**
     * @ORM\Column(type="text")
     */
    private $trailer;



    /**
     *@var \Doctrine\Common\Collections\ArrayCollection
     * Many TVShows have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tvshows", cascade={"persist"})
     */
    private $users;

    /**
    *@var \Doctrine\Common\Collections\ArrayCollection
    * Many tvshows have many news
    * @ORM\ManyToMany(targetEntity="news", inversedBy="tvshows", cascade={"persist"})
    * @ORM\JoinTable(name="tvshow_news",
    *                 joinColumns={
    *                     @ORM\JoinColumn(name="tvshow_id", referencedColumnName="id", nullable=true)
    *                 },
    *                 inverseJoinColumns={
    *                     @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=true)
    *                 }
    * )
    */
    private $news;

    /**
     *@var \Doctrine\Common\Collections\ArrayCollection
     * One tvshow has many comments.
     * @ORM\OneToMany(targetEntity="comments", mappedBy="belongsToTVShow", cascade={"persist"})
     */
    private $comments;

    /**
    *One tvshow has many ratings given
    *@var \Doctrine\Common\Collections\ArrayCollection
    *@ORM\OneToMany(targetEntity="ratings", mappedBy="belongsToTVShow", cascade={"persist"})
    *ratings keeps track of all ratings given
    */
    private $ratings;

    /**
    *@ORM\Column(type="float")
    */
    private $totalRating;

    /**
    *One tvshow has many episodes
    *@var \Doctrine\Common\Collections\ArrayCollection
    *@ORM\OneToMany(targetEntity="episodes", mappedBy="belongsToTVShow", cascade={"persist"})
    */
    private $episodes;

    public function __construct() {
        $this->type = "tvshow";
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->episodes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return tvshow
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

    /**1
     * Set description
     *
     * @param string $description
     *
     * @return tvshow
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
     * Set premiere
     *
     * @param \DateTime $premiere
     *
     * @return tvshow
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

    /**
     * Set picture
     *
     * @return tvshow
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        setPictureBase64($picture);

        return $this;
    }

    /**
     * Get picture
     *
     * @return \LONGBLOB
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return tvshow
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add news
     *
     * @param \AppBundle\Entity\news $news
     *
     * @return tvshow
     */
    public function addNews(\AppBundle\Entity\news $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \AppBundle\Entity\news $news
     */
    public function removeNews(\AppBundle\Entity\news $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    public function __toString()
    {
      return $this->getName();
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\comments $comment
     *
     * @return tvshow
     */
    public function addComment(\AppBundle\Entity\comments $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\comments $comment
     */
    public function removeComment(\AppBundle\Entity\comments $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set totalRating
     *
     * @param float $totalRating
     *
     * @return tvshow
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
     * Add rating
     *
     * @param \AppBundle\Entity\ratings $rating
     *
     * @return tvshow
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
     * Add episode
     *
     * @param \AppBundle\Entity\episodes $episode
     *
     * @return tvshow
     */
    public function addEpisode(\AppBundle\Entity\episodes $episode)
    {
        $this->episodes[] = $episode;

        return $this;
    }

    /**
     * Remove episode
     *
     * @param \AppBundle\Entity\episodes $episode
     */
    public function removeEpisode(\AppBundle\Entity\episodes $episode)
    {
        $this->episodes->removeElement($episode);
    }

    /**
     * Get episodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return tvshow
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return tvshow
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set airson
     *
     * @param string $airson
     *
     * @return tvshow
     */
    public function setAirson($airson)
    {
        $this->airson = $airson;

        return $this;
    }

    /**
     * Get airson
     *
     * @return string
     */
    public function getAirson()
    {
        return $this->airson;
    }

    /**
     * Set runtime
     *
     * @param string $runtime
     *
     * @return tvshow
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return string
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return tvshow
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdby
     *
     * @param string $createdby
     *
     * @return tvshow
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return string
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set imdb
     *
     * @param string $imdb
     *
     * @return tvshow
     */
    public function setImdb($imdb)
    {
        $this->imdb = $imdb;

        return $this;
    }

    /**
     * Get imdb
     *
     * @return string
     */
    public function getImdb()
    {
        return $this->imdb;
    }

    /**
     * Set tvcom
     *
     * @param string $tvcom
     *
     * @return tvshow
     */
    public function setTvcom($tvcom)
    {
        $this->tvcom = $tvcom;

        return $this;
    }

    /**
     * Get tvcom
     *
     * @return string
     */
    public function getTvcom()
    {
        return $this->tvcom;
    }

    /**
     * Set trailer
     *
     * @param string $trailer
     *
     * @return tvshow
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return string
     */
    public function getTrailer()
    {
        return $this->trailer;
    }
}

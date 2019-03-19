<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\NewsRepository")
 * @ORM\Table(name="news")
 */

 class news{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
     private $id;

     /**
      * @ORM\Column(type="text")
      */
     private $title;

     /**
      * @ORM\Column(type="text")
      */
     private $description;

     /**
      * @ORM\Column(type="datetime")
      */
     private $publish_date;

     /**
      * @ORM\Column(type="text")
      */
     private $the_news;

     /**
      * @ORM\Column(type="blob")
      */
     private $picture;

     /**
      * @var \Doctrine\Common\Collections\ArrayCollection
      * @ORM\Column(type="blob")
      */
     //private $pictures;

     //every news article can be about multiple tvshows/movies.
     //these news articles will have the tvshows/movies as tags at the end

     /**
      *@var \Doctrine\Common\Collections\ArrayCollection
      * Many news have many tvshows/movies.
      * @ORM\ManyToMany(targetEntity="tvshow", mappedBy="news", cascade={"persist"} )
      */
     private $tvshows;

     /**
      *@var \Doctrine\Common\Collections\ArrayCollection
      * Many news have many tvshows/movies.
      * @ORM\ManyToMany(targetEntity="movie", mappedBy="news", cascade={"persist"})
      */
     private $movies;

     /**
      *@var \Doctrine\Common\Collections\ArrayCollection
      * One news article has many comments.
      * @ORM\OneToMany(targetEntity="comments", mappedBy="belongsToNews", cascade={"persist"})
      */
     private $comments;

     public function __construct() {
         $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
         $this->tvshows = new \Doctrine\Common\Collections\ArrayCollection();
         $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
         $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return news
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return news
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
     * Set publishDate
     *
     * @param \DateTime $publishDate
     *
     * @return news
     */
    public function setPublishDate($publishDate)
    {
        $this->publish_date = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publish_date;
    }

    /**
     * Set theNews
     *
     * @param string $theNews
     *
     * @return news
     */
    public function setTheNews($theNews)
    {
        $this->the_news = $theNews;

        return $this;
    }

    /**
     * Get theNews
     *
     * @return string
     */
    public function getTheNews()
    {
        return $this->the_news;
    }

    /**
     * Set pictures
     *
     * @param string $pictures
     *
     * @return news
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * Get pictures
     *
     * @return string
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Add tvshow
     *
     *
     * @return news
     */
    public function addTvshow($tvshow)
    {
        $this->tvshows[] = $tvshow;

        return $this;
    }

    /**
     * Remove tvshow
     *
     * @param \AppBundle\Entity\tvshow $tvshow
     */
    public function removeTvshow(\AppBundle\Entity\tvshow $tvshow)
    {
        $this->tvshows->removeElement($tvshow);
    }

    /**
     * Get tvshows
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTvshows()
    {
        return $this->tvshows;
    }

    /**
     * Add movie
     *
     *
     * @return news
     */
    public function addMovie($movie)
    {
        $this->movies[] = $movie;

        return $this;
    }

    /**
     * Remove movie
     *
     * @param \AppBundle\Entity\movie $movie
     */
    public function removeMovie(\AppBundle\Entity\movie $movie)
    {
        $this->movies->removeElement($movie);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
    * Set mainPicture
    *
    *
    * @return news
     */
    public function setMainPicture($mainPicture)
    {
        $this->main_picture = $mainPicture;

        return $this;
    }

    /**
     * Get mainPicture
     *
     */
    public function getMainPicture()
    {
        return $this->main_picture;
    }


    /**
     * Add comment
     *
     * @param \AppBundle\Entity\comments $comment
     *
     * @return news
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
     * Set picture
     *
     * @param string $picture
     *
     * @return news
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }
}

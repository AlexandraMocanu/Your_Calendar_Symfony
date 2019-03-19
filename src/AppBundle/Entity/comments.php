<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommentsRepository")
 * @ORM\Table(name="comments")
 */

class comments{

     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
      private $id;

      /**
      * @ORM\Column(type="string", length=100)
      */
      private $title;

      /**
      * @ORM\Column(type="text")
      */
      private $comment;

      /**
       * @ORM\Column(type="datetime")
       */
      private $published;

      /**
      * Many comments have one user
      * @ORM\ManyToOne(targetEntity="User", inversedBy="comments", cascade={"persist"})
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      */
      private $user;

      /**
      * One comment is for one tvshow/movie/news article/
      * @ORM\ManyToOne(targetEntity="news", inversedBy="comments", cascade={"persist"})
      * @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToNews;

      /**
      * One comment is for one tvshow/movie/news article/
      * @ORM\ManyToOne(targetEntity="tvshow", inversedBy="comments", cascade={"persist"})
      * @ORM\JoinColumn(name="tvshow_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToTVShow;

      /**
      * One comment is for one tvshow/movie/news article/
      * @ORM\ManyToOne(targetEntity="movie", inversedBy="comments", cascade={"persist"})
      * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
      */
      private $belongsToMovie;

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
     * @return comments
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
     * Set comment
     *
     * @param string $comment
     *
     * @return comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     *
     * @return comments
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return comments
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set belongsToNews
     *
     * @param \AppBundle\Entity\news $belongsToNews
     *
     * @return comments
     */
    public function setBelongsToNews(\AppBundle\Entity\news $belongsToNews = null)
    {
        $this->belongsToNews = $belongsToNews;

        return $this;
    }

    /**
     * Get belongsToNews
     *
     * @return \AppBundle\Entity\news
     */
    public function getBelongsToNews()
    {
        return $this->belongsToNews;
    }

    /**
     * Set belongsToTVShow
     *
     * @param \AppBundle\Entity\tvshow $belongsToTVShow
     *
     * @return comments
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
     * @return comments
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
}

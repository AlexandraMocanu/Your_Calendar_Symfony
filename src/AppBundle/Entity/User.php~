<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="username", message="Username already in use. Please choose another one.")
 * @UniqueEntity(fields="email", message="This email is already registered with an account.")
 */

class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    *@var \Doctrine\Common\Collections\ArrayCollection
    * One user has many movies
    * @ORM\ManyToMany(targetEntity="movie", inversedBy="users", cascade={"persist"})
    * @ORM\JoinTable(name="users_movies",
    *                 joinColumns={
    *                     @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
    *                 },
    *                 inverseJoinColumns={
    *                     @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=true)
    *                 }
    * )
    */
    private $movies;

    /**
    *@var \Doctrine\Common\Collections\ArrayCollection
    * Many users have many tvshows
    * @ORM\ManyToMany(targetEntity="tvshow", inversedBy="users", cascade={"persist"})
    * @ORM\JoinTable(name="users_tvshows",
    *                 joinColumns={
    *                     @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
    *                 },
    *                 inverseJoinColumns={
    *                     @ORM\JoinColumn(name="tvshow_id", referencedColumnName="id", nullable=true)
    *                 }
    * )
    */
    private $tvshows;

    /**
    *@var \Doctrine\Common\Collections\ArrayCollection
    * One user has many comments
    * @ORM\OneToMany(targetEntity="comments", mappedBy="user", cascade={"persist"})
    */
    private $comments;

    /**
    *@var \Doctrine\Common\Collections\ArrayCollection
    * One user has many ratings given
    * @ORM\OneToMany(targetEntity="ratings", mappedBy="givenBy", cascade={"persist"})
    */
    private $ratingsGiven;

    public function __construct() {
        parent::__construct();
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tvshows = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratingsGiven = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add movie
     *
     * @param \AppBundle\Entity\movie $movie
     *
     * @return User
     */
    public function addMovie(\AppBundle\Entity\movie $movie)
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
     * Add tvshow
     *
     * @param \AppBundle\Entity\tvshow $tvshow
     *
     * @return User
     */
    public function addTvshow(\AppBundle\Entity\tvshow $tvshow)
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
     * Add comment
     *
     * @param \AppBundle\Entity\comments $comment
     *
     * @return User
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
     * Add ratingsGiven
     *
     * @param \AppBundle\Entity\ratings $ratingsGiven
     *
     * @return User
     */
    public function addRatingsGiven(\AppBundle\Entity\ratings $ratingsGiven)
    {
        $this->ratingsGiven[] = $ratingsGiven;

        return $this;
    }

    /**
     * Remove ratingsGiven
     *
     * @param \AppBundle\Entity\ratings $ratingsGiven
     */
    public function removeRatingsGiven(\AppBundle\Entity\ratings $ratingsGiven)
    {
        $this->ratingsGiven->removeElement($ratingsGiven);
    }

    /**
     * Get ratingsGiven
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatingsGiven()
    {
        return $this->ratingsGiven;
    }
}

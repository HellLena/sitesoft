<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="text")
     */
    protected $post;

    public function getId(){
        return $this->id;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getUserId($user_id){
        return $user_id;
    }

    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function setPost($post){
        $this->post = strip_tags($post);
    }

    public function getPost(){
        return $this->post;
    }
}
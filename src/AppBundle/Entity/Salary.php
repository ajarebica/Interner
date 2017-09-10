<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="salary")
*/

class Salary
{

/**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue(strategy="AUTO")
*/
    private $id;

/**
* @ORM\Column(type="integer", length=100)
*/
    private $user_id;

/**
* @ORM\Column(type="decimal", length=100)
*/
    private $amount;



    public function getId(){
        return $this->id;
    }


    public function getSalary(){
        return $this->amount;
    }

    public function setSalary($salary){
        $this->amount=$salary;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setUserId($uid){
        $this->user_id=$uid;
    } 

}
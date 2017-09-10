<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="employee")
*/

class Employee
{

/**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue(strategy="AUTO")
*/
    private $id;

/**
* @ORM\Column(type="string", length=100)
*/
    private $first_name;

/**
* @ORM\Column(type="string", length=100)
*/
    private $last_name;

/**
* @ORM\Column(type="date", length=100)
*/
    private $birth_date;

/**
* @ORM\Column(type="string", length=100)
*/
    private $birth_country;

/**
* @ORM\Column(type="string", length=100)
*/
    private $job_position;

/**
* @ORM\Column(type="decimal", length=100)
*/
    private $salary;

/**
* @ORM\Column(type="date", length=100)
*/    
    private $start_date;
/**
* @ORM\Column(type="string", length=100)
*/    
    private $end_date;

    public function __construct()
    {
        $this->end_date = date('d-m-Y');
    }


    public function getId(){
        return $this->id;
    }


    public function getFirstName(){
    	return $this->first_name;
    }

    public function setFirstName($first){
    	$this->first_name=$first;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function setLastName($last){
        $this->last_name=$last;
    } 

    public function getBirthDate(){
        return $this->birth_date;
    }

    public function setBirthDate($bdate){
        $this->birth_date=$bdate;
    } 

    public function getBirthCountry(){
        return $this->birth_country;
    }

    public function setBirthCountry($bcountry){
        $this->birth_country=$bcountry;
    }

    public function getJobPosition(){
        return $this->job_position;
    }

    public function setJobPosition($jposition){
        $this->job_position=$jposition;
    }

    public function getSalary(){
        return $this->salary;
    }

    public function setSalary($salary){
        $this->salary=$salary;
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function setStartDate($sdate){
        $this->start_date=$sdate;
    } 

    public function getEndDate(){
        return $this->end_date;
    }

    public function setEndDate(){
        date_default_timezone_set("Africa/Ceuta");
        $this->end_date=date('d-m-Y');
    }  

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

}
<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;
public function getID(){
    return $this->id;
}
    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;
public function getName(){
    return $this->name;

}
public function setName($name){
    $this->name = $name;
}
    /**
     * @MongoDB\Field(type="float")
     */

    protected $price;
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
    }
}

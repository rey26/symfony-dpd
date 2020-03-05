<?php

namespace App\Entity;

use App\Entity\BusinessHourModel;


class BranchModel
{
 /**
 * @var string
 */
 private $internalId;
 /**
 * @var string
 */
 private $internalName;
 /**
 * @var Coordinates
 */
 private $location;
 /**
 * @var array|BusinessHourModel[]
 */
 private $businessHours;
 /**
 * @var Address
 */
 private $address;

 /**
 * @var string
 */
 private $phoneNumber;
 /**
 * @var string
 */
 private $email;

 public function __construct($item){
    $this->internalId = $item->id;
    $this->internalName = $item->company;
    $this->email = $item->email;
    $this->phoneNumber = $item->phone;
    $this->address = $item->street . ' ' . $item->house_number . ', ' . $item->postcode . ' ' . $item->city;
    $this->location = 'Latitude: ' . $item->latitude . ', Longitude: ' . $item->longitude;
    $this->businessHours = array();
    foreach($item->hours as $hours){
        $hours = new BusinessHourModel($hours);
        array_push($this->businessHours, $hours->getHoursData());
    }
 }

 public function getBranchData(){
    return get_object_vars($this);
 }


}

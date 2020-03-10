<?php

namespace App\Entity;

use App\Entity\BusinessHourModel;
use Symfony\Component\HttpClient\HttpClient;


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

 public static function getAllBranches()
 {
     $client = HttpClient::create();
     $response = $client->request('GET', 'http://www.dpdparcelshop.cz/api/get-all');
     if($response->getStatusCode() != 200){
         return 'External service error';
     }
     
     $content = $response->getContent();
     $content = json_decode($content);

     $branches = array();
     foreach($content->data->items as $item){
         $branch = new BranchModel($item);
         array_push($branches, $branch->getBranchData());
     }
     return $branches;
 }

 public static function getBranchDetail($id)
 {
   $branches = self::getAllBranches();
   foreach($branches as $key => $branch){
       if($branch['internalId'] == $id)
           return $branches[$key];
   }
   return "Branch not found";
 }


}

<?php

namespace App\Entity;

class BusinessHourModel
{
 /**
 * @var string
 */
 private $dayOfWeek;
 /**
 * @var string
 */
 private $businessHour;

 public function __construct($day){
    $this->dayOfWeek = $day->dayName;
    $this->businessHour = $this->concatenateHours($day);
 }

 public function getHoursData(){
    return get_object_vars($this);
 }

 private function concatenateHours($day){
    $result = '';
    if(strlen($day->openMorning)){
        $result .= $day->openMorning . ' - ';
    }
    if(strcmp($day->closeMorning, $day->openAfternoon)){
        if(strlen($day->closeMorning)){
            $result .= $day->closeMorning;
        }
        if(strlen($day->openAfternoon)){
            $result .= ', ' . $day->openAfternoon . ' - ';
        }
    }
    if(strlen($day->closeAfternoon)){
        $result .= $day->closeAfternoon;
    }
    if(strlen($result) < 1){
        $result = 'Zatvorené';
    }
    return $result;
 }

}

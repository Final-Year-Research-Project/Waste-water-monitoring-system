<?php
class dht11{
 public $link='';
 function __construct($temperature, $humidity, $vibration, $amperage){
  $this->connect();
  $this->storeInDB($temperature, $humidity, $vibration, $amperage);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'temphumidnew') or die('Cannot ggg the DB');
 }
 
 function storeInDB($temperature, $humidity, $vibration, $amperage){
  $query = "insert into dht11 set humidity='".$humidity."', temperature='".$temperature."', vibration='".$vibration."', amperage='".$amperage."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['temperature'] != '' and  $_GET['humidity'] != ''and  $_GET['vibration'] != ''and  $_GET['amperage'] != ''){
 $dht11=new dht11($_GET['temperature'],$_GET['humidity'],$_GET['vibration'],$_GET['amperage']);
}
?>
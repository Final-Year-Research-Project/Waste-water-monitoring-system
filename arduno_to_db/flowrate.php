<?php
class flowrate{
 public $link='';
 function __construct($flow_in, $flow_out,$temperature){
  $this->connect();
  $this->storeInDB($flow_in, $flow_out,$temperature);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'temphumidnew') or die('Cannot connect the DB');
 }
 
 function storeInDB($flow_in, $flow_out){
  $query = "insert into flowrate set flow_in='".$flow_in."', flow_out='".$flow_out."',temperature='".$temperature."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['flow_in'] != '' and  $_GET['flow_out'] != '' and $_GET['temperature'] != ''){
 $flowrate=new flowrate($_GET['flow_in'],$_GET['flow_out'],$_GET['temperature']);
}
?>
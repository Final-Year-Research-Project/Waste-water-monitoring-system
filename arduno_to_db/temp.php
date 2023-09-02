<?php
class temp{
 public $link='';
 function __construct($temp){
  $this->connect();
  $this->storeInDB($temp);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'temphumidnew') or die('Cannot ggg the DB');
 }
 
 function storeInDB($temp){
  $query = "insert into temp set temperature='".$temp.";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['temperature'] != ''){
 $temp=new temp($_GET['temperature']);
}
?>
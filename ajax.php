<?php
error_reporting(E_ERROR | E_PARSE);

Global $db;

$db = new PDO("mysql:host=localhost;dbname=biblioteka", 'root', '');


if(isset($_REQUEST["prozor"])){
  $prozor = $_REQUEST["prozor"];
}else{
  $prozor = "";
}

switch($prozor){
  case "list_books":

  $books_query = $db->prepare("SELECT *
                      FROM books
                      ");
  $books_query->execute();
  while($row = $books_query->fetch()){
    $id = $row["id"];
    $stanje = $row["book_number"];

    $reservation_query = $db->prepare("SELECT *
                        FROM rezervacije
                        WHERE book_id = $id AND status = 1");

    $reservation_query->execute();
    $brojac = $reservation_query->rowCount();

    if($brojac < $stanje){
      echo '<option value="'.$id.'">'.$row["name"].'</option>';
    }
  }

  break;

}


?>

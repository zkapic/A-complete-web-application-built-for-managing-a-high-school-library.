<?php
error_reporting(E_ERROR | E_PARSE);

include("connect.php");

$status = $db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
global $logovani_id;


function printName(){
  Global $db;
  $logovani_id = $_COOKIE['biblioteka'];
  $query = $db->prepare("SELECT username
                      FROM users
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $logovani_id
              ));
  $row = $query->fetch();

  return $row["username"];
}

function loggedStatus(){
  Global $db;
  $logovani_id = $_COOKIE['biblioteka'];
  $query = $db->prepare("SELECT status
                      FROM users
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $logovani_id
              ));
  $row = $query->fetch();

  return $row["status"];
}

function printBookCounter(){
  Global $db;
  $query = $db->prepare("SELECT book_number
                      FROM books
                      ");
  $query->execute();
  $counter = 0;
  while($row = $query->fetch()){
    $counter = $counter + $row["book_number"];
  }

  return $counter;
}

function printStudentCounter(){
  Global $db;
  $query = $db->prepare("SELECT id
                      FROM students
                      ");
  $query->execute();

  $counter = $query->rowCount();

  return $counter;
}

function printUserCounter(){
  Global $db;
  $query = $db->prepare("SELECT id
                      FROM users
                      ");
  $query->execute();

  $counter = $query->rowCount();

  return $counter;
}


function printWriterName($id){
  Global $db;
  $query = $db->prepare("SELECT name
                      FROM writers
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $id
              ));
  $row = $query->fetch();

  return $row["name"];
}

function printZanrName($id){
  Global $db;
  $query = $db->prepare("SELECT name
                      FROM zanr
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $id
              ));
  $row = $query->fetch();

  return $row["name"];
}

function checkStudentReservation($id){
  Global $db;
  $query = $db->prepare("SELECT id
                      FROM rezervacije
                      WHERE student_id = :student_id AND status = 1
                      ");
  $query->execute(array(
                ':student_id' => $id
              ));

  return $query->rowCount();
}

function bookDifference($id){
  Global $db;
  $query = $db->prepare("SELECT id
                      FROM rezervacije
                      WHERE book_id = :book_id AND status = 1
                      ");
  $query->execute(array(
                ':book_id' => $id
              ));

  return $query->rowCount();
}


?>

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
  case "login":

  $username = $_POST["username"];
  $pass = $_POST["password"];
  $login_query = $db->prepare("SELECT *
                      FROM users
                      WHERE username = :username AND status = :status
                      ");
  $login_query->execute(array(
                ':username' => $username,
                ':status' => 1
              ));
  $row = $login_query->fetch();

  if(md5($pass) == $row["password"]){
    setcookie('biblioteka', $row["id"], time()+60*60*24*30);
    header("Location: index.php");
  }else{
    header("Location: login.php?poruka=2");
  }
  break;

  case "logout":
  setcookie ("cookie_name", "", time() - 3600);
  header("Location: login.php?poruka=2");

  break;

  case "add_book":

  $name = $_POST["name"];
  $date = $_POST["date"];
  $writer = $_POST["writer"];
  $zanr = $_POST["zanr"];
  $stanje = $_POST["stanje"];

  $query = $db->prepare("INSERT
                      INTO books(name, publishing_date, writer_id, zanr_id, book_number)
                      VALUES (:name, :publishing_date, :writer_id, :zanr_id, :book_number)
                      ");
  $query->execute(array(
                ':name' => $name,
                ':publishing_date' => $date,
                ':writer_id' => $writer,
                ':zanr_id' => $zanr,
                ':book_number' => $stanje,
              ));

  header("Location: books.php?poruka=1");

  break;

  case "edit_stanje":

  $id = $_POST["id_stanja"];
  $stanje = $_POST["stanje_edit"];

  $query = $db->prepare("UPDATE books
                      SET book_number = :book_number
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $id,
                ':book_number' => $stanje
              ));

  header("Location: books.php?poruka=2");

  break;

  case "delete_book":

  $id = $_GET["id"];

  $query = $db->prepare("DELETE
                        FROM books
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $id
              ));

  header("Location: books.php?poruka=3");

  break;

  case "add_student":

  $name = $_POST["name"];
  $date = $_POST["date"];
  $surname = $_POST["surname"];
  $razred = $_POST["razred"];

  $query = $db->prepare("INSERT
                      INTO students(name, surname, class, register_date)
                      VALUES (:name, :surname, :class, :register_date)
                      ");
  $query->execute(array(
                ':name' => $name,
                ':surname' => $surname,
                ':class' => $razred,
                ':register_date' => $date
              ));

  header("Location: students.php?poruka=1");

  break;

  case "delete_employee":

  $id = $_GET["id"];

  $query = $db->prepare("UPDATE users
                      SET status = :status
                      WHERE id = :id
                      ");
  $query->execute(array(
                ':id' => $id,
                ':status' => 3
              ));

  header("Location: employees.php?poruka=2");

  break;

  case "add_employee":

  $username = $_POST["username"];
  $password = $_POST["password"];
  $status = $_POST["status"];

  $query = $db->prepare("INSERT
                      INTO users(username, password, status)
                      VALUES (:username, :password, :status)
                      ");
  $query->execute(array(
                ':username' => $username,
                ':password' => md5($password),
                ':status' => $status
              ));

  header("Location: employees.php?poruka=1");

  break;

  case "rent_book":

  $student = $_POST["id_studenta"];
  $user = $_COOKIE['biblioteka'];
  $book = $_POST["knjiga"];
  $register_date = date("Y-m-d");

  $query = $db->prepare("INSERT
                      INTO rezervacije(book_id, student_id, user_id, register_date, status)
                      VALUES (:book_id, :student_id, :user_id, :register_date, :status)
                      ");
  $query->execute(array(
                ':book_id' => $book,
                ':student_id' => $student,
                ':user_id' => $user,
                ':register_date' => $register_date,
                ':status' => 1
              ));
  header("Location: students.php?poruka=2");

  case "return_book":

  $student = intval($_GET["student"]);
  
  $query = $db->prepare("UPDATE rezervacije
                      SET status = :status
                      WHERE student_id = :student_id
                      ORDER BY id DESC LIMIT 1
                      ");
  $query->execute(array(
                ':student_id' => $student,
                ':status' => 0
              ));

  header("Location: students.php?poruka=3");

  break;

  break;
}


?>

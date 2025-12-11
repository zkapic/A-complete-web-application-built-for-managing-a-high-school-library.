<?php
Global $db;

$db = new PDO("mysql:host=localhost;dbname=biblioteka", 'root', '');
if (!isset($_COOKIE['biblioteka'])) {
    header("Location: login.php");
}else{

}
include("includes/functions.php");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BIBLIOTEKA-Učenici</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function(){
    $(".modalIznajmi").on( "click", function(){
      var id = $(this).data('student');
      $("#id_studenta").val(id);
        $.ajax({
          url: 'ajax.php?prozor=list_books',
          dataType: 'html',
          success: function(data) {
            console.log(data);
            $("#knjiga_select").html(data);
          },
        });
  });
  });
</script>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo.png" height="100" width="100"/>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Početna</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="books.php" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Knjige</span>
        </a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link collapsed" href="students.php" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Učenici</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="employees.php" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Zaposlenici</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo printName();?></span>
                <img class="img-profile rounded-circle" src="https://svgshare.com/getbyhash/sha1-yMxr0zPp2hm5mjc6LEAzwdHQO+k=">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-book"></i> Učenici</h1>
            <a href="#"  data-toggle="modal" data-target="#addStudentModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Dodaj učenika</a>

          </div>
          <!-- Page Heading -->

          <?php if(isset($_GET["poruka"])){
              if($_GET["poruka"] == 1){?>
                <div class="alert alert-primary" role="alert">
                  Uspješno ste dodali učenika.
                </div>
              <?php }
              if($_GET["poruka"] == 2){?>
                <div class="alert alert-info" role="alert">
                  Uspješno ste dodijelili knjigu.
                </div>
              <?php }
              if($_GET["poruka"] == 3){?>
                <div class="alert alert-info" role="alert">
                  Uspješno ste vratili knjigu.
                  </div>
              <?php }
          } ?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Lista učenika</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="text-center">Ime i prezime</th>
                      <th class="text-center">Datum registracije</th>
                      <th class="text-center">Razred</th>
                      <th class="text-center">Dodijeli knjigu</th>
                      <th class="text-center">Vrati knjigu</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $books_query = $db->prepare("SELECT *
                                      FROM students
                                      ");
                  $books_query->execute();
                  while($row = $books_query->fetch()){
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $row["name"].$row["surname"]; ?></td>
                      <td class="text-center"><?php echo $row["register_date"]; ?></td>
                      <td class="text-center"><?php echo $row["class"]; ?></td>
                      <td class="text-center">
                      <?php if(checkStudentReservation($row[id])<1){ ?>
                        <a href="#" data-toggle="modal" style="color:green" data-target="#iznajmiModal" class="modalIznajmi" data-student="<?php echo $row["id"];?>">
                          <i class="fas fa-book-reader fa-sm fa-fw mr-2"></i>
                        </a>
                      <?php }?>
                      </td>
                      <td class="text-center">
                        <?php if(checkStudentReservation($row[id])>0){ ?>
                        <a href="do.php?prozor=return_book&student=<?php echo $row[id];?>" style="color:blue" class="modalVrati" >
                          <i class="fas fa-book fa-sm fa-fw mr-2"></i>
                        </a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; ZK 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Želite se odjaviti?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Kliknite na logout za odjavu sesije.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Odustani</button>
          <a class="btn btn-primary" href="do.php?prozor=logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Dodijeli knjigu -->
  <div class="modal fade" id="iznajmiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Želite iznajmiti knjigu?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="do.php?prozor=rent_book" method="POST">
          <input name="id_studenta" id="id_studenta" type="hidden" value=""></input>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="knjiga">Odaberi knjigu</label>
              <select id="knjiga_select" name="knjiga" class="form-control">

              </select>
            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Odustani</button>
          <button class="btn btn-primary" type="submit">Iznajmi</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <!-- ADD STUDENT Modal-->
  <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Želite dodati studenta?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="do.php?prozor=add_student" method="POST">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Ime</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Ime">
            </div>
            <div class="form-group col-md-6">
              <label for="surname">Prezime</label>
              <input type="text" class="form-control" id="surname" name="surname" placeholder="Prezime">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="date">Datum registracije</label>
              <input type="date" class="form-control" id="date" name="date" placeholder="Datum registracije">
            </div>
            <div class="form-group col-md-6">
              <label for="razred">Razred</label>
              <select id="razred" name="razred" class="form-control">
                <option disabled>Choose...</option>
                <option value="1">Prvi</option>
                <option value="2">Drugi</option>
                <option value="3">Treći</option>
                <option value="4">Četvrti</option>
              </select>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Odustani</button>
          <button type="submit" class="btn btn-primary">Dodaj</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
<?php ?>

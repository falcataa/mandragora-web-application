<!DOCTYPE html>
<html>
  <head>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css">
  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="catalog.html" class="nav-link">Home</a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->
    </div>
    <!-- ./wrapper -->

    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  File name:
  <input type="text" name="fileName" id="fileName">
  Description:
  <input type="text" name="description" id="description">
  User ID:
  <input type="number" name="user_id" id="user_id" value="0">

  <input type="submit" value="Upload Image" name="submit">
</form>

  </body>
</html>

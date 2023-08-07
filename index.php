<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="mycss.css">
  <script type="text/javascript" src="myjs.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <title>Register</title>
  <link rel="icon" href="./images/reg.png" type="image/x-icon">
</head>

<body class="myform">
  <form method="post" enctype="multipart/form-data" class="myf">
    <h1> Register Here!</h1>

    <div class="form-floating mb-3" onclick="myste(); myFunction(this, 'blue')">
      <input type="text" class="form-control" id="floatingInput" name="Uname" placeholder="Your name" required>
      <label for="floatingInput">Enter Your Name</label>
    </div>


    <div class="form-floating mb-3 " onclick="myste(); myFunction(this, 'blue')">
      <input type="text" inputmode="tel" class="form-control" id="floatingPassword" placeholder="Phone number" required name="phonenumber" value="" maxlength="10">
      <label for="floatingPassword">Phone Number</label>
    </div>
    <div class="form-floating mb-3" onclick="myste(); myFunction(this, 'blue')">
      <input type="password" class="form-control" id="af" placeholder="Password" name="password1" required>
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating mb-3" onclick="myste(); myFunction(this, 'blue')">
      <input type="password" class="form-control" id="af" placeholder="Password" name="password2" required>
      <label for="floatingPassword">Confirm Password</label>
    </div>


    <div class="form-floating mb-3 center" onclick="dis()" id="fiuplod">
      <button class="btn mybtn box overlay  " ><img src="images/pro.png" class="image"> set a photo...
        <input type="file" class="file box " name="file" style="font-size:160%" onchange="previewImage(this)"  required>
      </button>

    </div>

    <div><br><br><br></div>
    <div class="form-floating">
      <div style="font-size: 10px;margin-top:0px;padding-top:0px;">Only jpg/png files with less than 20KB is supported! </div>
      <button id="dis" type="submit" class=" mybtn2" name="submit"><i class="fa fa-send-o" ></i> SUBMIT ENTRY</button>
    </div>
    
    <div class="preview-container">
    <img id="imagePreview" class="preview-image" src="#" alt="Preview" >
  </div>
    <script>
function previewImage(input) {
  var preview = document.getElementById('imagePreview');
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function dis(){
    // alert("hi");
    document.getElementById("imagePreview").style.display="inline";
}

</script>

  </form>




  <?php

  if (isset($_POST['submit'])) {
    include("connection.php");









    $mess1 = "";
    $mess2 = "";
    $mess3 = "";

    $error = "";
    $query = "select * from logindata where PhoneNumber='" . mysqli_real_escape_string($link, $_POST['phonenumber']) . "'limit 1";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
      $error = "This Phone Number is already taken! Please try with another Phone number.";
    } else {
      // echo $_POST['password1'];
      if ($_POST['password1'] == $_POST['password2']) {
        $reladd = "";
        if ($_FILES['file']['error'] == 0) {
          // echo ($_FILES['file']['size']);
          if (($_FILES['file']['type'] == 'image/jpg' || $_FILES['file']['type'] == 'image/png') && $_FILES['file']['size'] < 20500) {
            // print_r($_FILES['file']);
            $source = $_FILES["file"]["tmp_name"];
            $des = $_SERVER['DOCUMENT_ROOT'] . "//images//" . $_FILES["file"]["name"];
            $reladd = "images/" . $_FILES["file"]["name"];
            $res = move_uploaded_file($source, $des);
            if ($res) {
              $mess1 = "<p>File uploaded successfully</p>";
            } else {
              $mess2 = "<p>File cannot be uploaded</p>";
            }
          } else {
            $mess3 = "<p>INVALID FORMAT </p><p>(Keep the size less than 10kb and jpg or png format is only supported)<br>Register again!</p>";
          }
        }






        $query = "insert into logindata (Name, PhoneNumber, Password1, Image) values('" . mysqli_real_escape_string($link, $_POST['Uname']) . "'," . mysqli_real_escape_string($link, $_POST['phonenumber']) . ",'" . mysqli_real_escape_string($link, md5(md5($_POST['Uname']) . $_POST['password1'])) . "','" . mysqli_real_escape_string($link, $reladd) . "')";
      } else {
        $error = "<p>Password didn't match .. try again</p>";
      }

      if ($mess3 == "" && !mysqli_query($link, $query)) {
        $error = "<p>Could not sign you up .. try again</p>";
      }
    }

    echo $error;
    echo $mess1;
    echo $mess2;

    echo $mess3;
  }
  ?>
  <button id="dis1"><img src="images/pre.png" style="height:30px;width:30px"> Preview</button>

  <div class="popup">
    <!-- <button id="close">&times;</button> -->
    <h2>Registration Details</h2>
    <p>
      <?php
      if (isset($_POST['submit'])) {

        echo "<div><img src='" . $reladd . "'width='239px' height='291px'><div>";
        // echo $result;
        echo "<i class='fa fa-user' style='font-size:24px'></i> " . $_POST['Uname'] . "<br>";
        echo '<i class="fa fa-phone" style="font-size:24px"></i> ' . $_POST['phonenumber'] . '<br>';
      } else {
        echo "Please first fill the Form";
      }
      ?>
    </p>
    <a href="index.php">Let's Go</a>
  </div>

  <script type="text/javascript">
    document.getElementById("dis").onclick = function() {
      document.querySelector("#dis1").style.display = "inline";
    }
    document.getElementById("dis1").onclick = function() {

      document.querySelector(".popup").style.display = "block";
      document.querySelector("#fiuplod").style.display = "none";
      document.querySelector(".myf").style.filter = "blur(5px)";



    };
  </script>


</body>

</html>
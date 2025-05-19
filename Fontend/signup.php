<?php 
  $userName = $_POST['userName'];
  $email = $_POST['email'];
  $loginpassword = $_POST['loginpassword'];
  {if ($email  === 'admin123@gmail.com') {
    echo '<script>alert("Invalid email"); window.location.href = "login.php";</script>';
  } else 
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'toy-shop');
    if ($conn->connect_error) {
      echo "$conn->connect_error";
      die("Connection Failed : " . $conn->connect_error);
    } else {
      $stmt = $conn->prepare("insert into login(userName, email, loginpassword) values(?, ?, ?)");
      $stmt->bind_param("sss", $userName, $email, $loginpassword);
      $execval = $stmt->execute();
      echo $execval;
      header('Location: login.html');
      $stmt->close();
      $conn->close();
    }
  }
?>
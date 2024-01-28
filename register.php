<?php
  $fullname = $_POST['fullname'];
  $uname = $_POST['uname'];
  $email  = $_POST['email'];
  $phnum = $_POST['phnum'];
  $pwd1 = $_POST['pwd1'];
  $pwd2 = $_POST['pwd2'];
  $gender = $_POST['gender'];
  $login = $_POST['loginType'];


  if ( !empty($fullname) || !empty($uname) || !empty($email) || !empty($phnum) || !empty($pwd1) || !empty($pwd2) || !empty($gender) || !empty($login) )
  {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "project";



    // Create connection
    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error())
    {
      die('Connect Error ('. mysqli_connect_errno() .') '
      . mysqli_connect_error());
    }
    else
    {
      $SELECT = "SELECT email From register Where email = ? Limit 1";
      $INSERT = "INSERT Into register (fullname,uname,email,phnum,pwd1,pwd2,gender,loginType)values(?,?,?,?,?,?,?,?)";

      //Prepare statement
      $stmt = $conn->prepare($SELECT);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($email);
      $stmt->store_result();
      $rnum = $stmt->num_rows;

      //checking username
      if ($rnum==0) 
      {
        $stmt->close();
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssssssss", $fullname, $uname , $email , $phnum , $pwd1, $pwd2 , $gender, $login);
        $stmt->execute();
        echo "New record inserted sucessfully";
      } 
      else 
      {
        echo "Someone already register using this email";
      }
      $stmt->close();
      $conn->close();
    }
  } 
  else 
  {
    echo "All field are required";
    die();
  }
?>
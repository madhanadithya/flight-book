<?php

$uname = $_POST['username'];
$pwd = $_POST['password'];
$login = $_POST['loginType'];

if ( !empty($uname) || !empty($pwd) || !empty($login) )
{

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "project";

    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error())
    {
        die('Connect Error ('. mysqli_connect_errno() .') '
        . mysqli_connect_error());
    }
    else{

        $query = "SELECT * FROM register WHERE uname = ? AND pwd1 = ? AND loginType = ?" ;
        $stmt = $conn->prepare($query);

        $stmt->bind_param("sss", $uname, $pwd, $login);
        $stmt->execute();

        $stmt->store_result();
        $user = $stmt->fetch();

        if ($user)
        {
            // Credentials are valid, redirect to the next page
           header("Location: /own_project/avail_check_form.html");
           echo "sucessfully logged in";
            exit();
        } 
        else 
        {
            // Credentials are invalid, you may show an error message or redirect back to the login page
            //header("Location: index.html?error=1");
            echo "loggin failed";
            exit();
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
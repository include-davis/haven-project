<?php
  // define variables and set to empty values
  $nameErr = $fnameErr = $lnameErr = $emailErr = $phoneErr = "";
  $fname = $lname = $email = $phone = "";

  if (!isset($_POST['fname'])){
    $fnameErr = "First name is required\n";
    echo $fnameErr;
  } else{
    $fname = $_POST['fname'];
    if (!preg_match("/^[a-zA-Z-']*$/",$fname)) {
      $nameErr = "Only letters are allowed\n";
      echo $nameErr;
    }
  }

  if (!isset($_POST['lname'])){
    $lnameErr = "Last name is required\n";
    echo $lnameErr;
  } else{
    $lname = $_POST['lname'];
    if (!preg_match("/^[a-zA-Z-']*$/",$lname)){
      $nameErr = "Only letters are allowed\n";
      echo $nameErr;
    }
  }

  if (!isset($_POST['Email'])){
    $emailErr = "Email is required\n\n";
    echo $emailErr;
  } else{
    $email = $_POST['Email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $emailErr = "Invalid email format\n";
      echo $emailErr;
    }
  }

  if (!empty($_POST['phone'])){
    $phone = $_POST['phone'];
    if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)){
      $phoneErr = "Invalid phone number\n";
      echo $phoneErr;
    }
    else {
      $check_phone_number = str_replace("-","",$phone);
      if (strlen($check_phone_number) < 10 || strlen($check_phone_number) > 14){
        $phoneErr = "Invalid phone number\n";
        echo $phoneErr;
      }
    }
  }

  $template_file = "./payment-email-template.php";

  $email_to = $email;
  $subject = "Thank you for your purchase!";
  $message = "Thank you for your recent purchase";

  $headers = "From: Haven Project <thehavenprojectthp@gmail.com>\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  if (file_exists($template_file)){
    $message = file_get_contents($template_file);
  } else{
    die("unable to locate the template file");
  }

  if (mail($email_to, $subject, $message, $headers)){
    echo "<hr />Thank you for your purchase, please check out your email\n";
  } else {
    echo "<hr />email not sent\n";
  }
?>
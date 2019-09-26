<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>New Captain Account</title>
        <script>
            //CE12

            function validLogin()
            {
                //we will set up the login validation in here.
                var error = false;
                var LetterName = /^[a-zA-Z]+$/;
                var emailExpression = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
                var passwordExpression = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
                console.log("Validating");
                if (document.getElementById("CapName").value == "" || !document.getElementById("CapName").value.match(LetterName))
                {
                    console.log("Name");
                    document.getElementById("CapName").classList.add("is-invalid");
                    error = true;
                }
                if (document.getElementById("Email").value == "" || !emailExpression.test(document.getElementById("Email").value))
                {
                    console.log("Email");
                    document.getElementById("Email").classList.add("is-invalid");
                    error = true;
                }
                if (document.getElementById("Password").value == "" || !passwordExpression.test(document.getElementById("Password").value))//.match(passwordExpression))
                {
                    console.log("Password");
                    document.getElementById("Password").classList.add("is-invalid");
                    error = true;
                }
                if (error == true)
                {
                    return false;
                }
            }
        </script>
        <?php
        require_once 'DataBaseConnection.php';
        include 'Header.php';
        print("<div class=\"container-fluid\">
            <div class=\"row\">
                <div class=\"col-sm-2\"></div>
                <div class=\"col-sm-8\">");
        if (isset($_POST['Submit'])) {
            //make the new account and link to login
            $name = $_POST['CapName'];
            $email = $_POST['Email'];
            $thePass = hash("ripemd128", $_POST['Password']);
            $insert = "INSERT INTO `CSIS2440`.`Captains` (`CaptainName`, `Email`, `Command`, `Combat`, `Commerce`, `Cunning`, `ThePass`) "
                    . "VALUES ('$name', '$email','" . rand(25, 100) . "', '" . rand(25, 100) . "', '" . rand(25, 100) . "', '" . rand(25, 100) . "','$thePass')";
            //echo $insert;
            $success = $con->query($insert);

            if ($success == FALSE) {
                $failmess = "Whole query " . $insert . "<br>";
                echo $failmess;
                print('Invalid query: ' . mysqli_error($con) . "<br>");
            } else {
                echo $name . " was Created<br><a href=\"LoginEcommerce.php\">Go back to login</a>";
            }
            print("</div>
                <div class=\"col-sm-2\"></div>
            </div>
            </div>");
        } else {
            //show the form
            print <<<HTML
            <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
            <form class="form-horizontal" action="NewAccountEcommerce.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="CapName">Captain Name</label>  
  <div class="col-md-4">
  <input id="CapName" name="CapName" type="text" placeholder="Harlock" class="form-control input-md" required="">
  <span class="help-block">This is the name of your Captain, all will see this</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Email">Email/Username</label>  
  <div class="col-md-4">
  <input id="Email" name="Email" type="text" placeholder="someone@home.org" class="form-control input-md" required="">
  <span class="help-block">This will be your contact email and username</span>  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Password">Password</label>
  <div class="col-md-4">
    <input id="Password" name="Password" type="password" placeholder="******************" class="form-control input-md" required="">
    <span class="help-block">This is the password you will use to access the account</span>
  </div>
</div>

<!-- Submit button-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Submit">Create Me</label>  
  <div class="col-md-4">
  <input id="Submit" name="Submit" type="Submit" placeholder="" class="form-control input-md" onclick="return validLogin()">
    
  </div>
</div>

</fieldset>
</form></div>
                <div class="col-sm-2"></div>
            </div>
            </div>

HTML;
        }

        include 'Footer.php';
        ?>
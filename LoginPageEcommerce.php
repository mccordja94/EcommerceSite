
<!DOCTYPE html>
<?php 
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In help</title>
        <?php
        include 'Header.php';
        //put your code here
        print <<<HTML
              
            <div>
            <form name="form1" method="post" action="LoginCheckEcommerce.php" >
                <table align = "center" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">

                    <tr>
                        <td colspan="3"><strong>Member Login </strong></td>

                    </tr>
                    <tr>
                        <td width="78">Username</td>
                        <td width="6">:</td>
                        <td width="294"><input name="myusername" type="text" id="myusername" class="error"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input name="mypassword" type="password" id="mypassword">                        </td>
HTML;
        
        if (isset($_SESSION['badPass'])){
            echo "<br> Username or password do not match";
        }
       print <<<HTML
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="Submit" value="Login" onclick="return loginfilled();"></td>
                    </tr>

                    <tr>
                        <td>

                            <a href="http://ec2-52-10-128-27.us-west-2.compute.amazonaws.com/CSIS2440/EcommerceSite/NewAccountEcommerce.php">Create an Account</a>

                        </td>
                    </tr>
                </table>
            </form>
        </div>
HTML;
       include 'Footer.php';
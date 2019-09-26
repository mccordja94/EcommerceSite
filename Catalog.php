<!DOCTYPE html>
<?php
session_start();
 $product_id = $_POST['Pick_Product'];
 $action = $_POST['action'];
 switch($action){
     case "Add":
         $_SESSION['cart'][$product_id] ++;
         break;
     case "Remove":
         $_SESSION['cart'][$product_id] --;
         if($_SESSION['cart'][$product_id] <= 0){
             unset($_SESSION['cart'][$product_id]);
         }
         break;
     case "Empty":
         unset($_SESSION['cart']);
         break;
     
     case "Info":    
         echo "alsdjflaksdjfdskfjalsd";
         $infonum = $product_id;
         echo "in ".$infonum;
         break;
 }
 print_r($_SESSION);
require_once "DataBaseConnection.php";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ecommerce</title>
        <?php
        include 'Header.php';
        // put your code here
        //print_r($_SESSION);
     
        ?>
        
        <!-- Custom fonts for this theme -->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Theme CSS -->

        <link href="../../../css/freelancer.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="col-sm-8">
        <form action="Catalog.php" method="Post">
            <div>
                <p><span class="text">Please Select a fooking product</span>
                    <select id="Pick_Product" name="Pick_Product" class="select">
                        <?php
                        $search = "SELECT Name, ProductID FROM CSIS2440.Ecommerce order by Name";
                        $return = $con->query($search);
                        if(!$return){
                            $message = "Whole query: " . $search;
                            echo $messge;
                            die('Invalid query: ' . mysqli_error());
                        }
                        while ($row = mysqli_fetch_array($return)){
                            if ($row['ProductID'] == $product_id){
                                echo"<option value='" . $row['ProductID'] . "' selected='selected'>" . $row['Name']. "</option>\n";
                                
                            }else{
                                echo "<option value='" . $row['ProductID'] . "'>" . $row['Name']. "</option>\n";
                            }
                        }
                        
                        ?>
                        
                        
                    </select></p>
                    <table>
                                <tr>
                                    <td>
                                        <input id="button_Add" type="submit" value="Add" name="action" class="button"/>
                                    </td>
                                    <td>
                                        <input name="action" type="submit" class="button" id="button_Remove" value="Remove"/>
                                    </td>
                                    <td>
                                        <input name="action" type="submit" class="button" id="button_empty" value="Empty"/>
                                    </td>
                                    <td>
                                        <input name="action" value="Info" type="submit" class="button" id="button_Info"  />
                                    </td>
                                </tr>                    
                            </table>

            </div>
            <div id="productinfo">
                
            </div>
            <div>
                <?php 
                if ($infonum > 0){
                    $sql =  "SELECT `Name`, `Description`, `Price`, `Img` FROM CSIS2440.Ecommerce WHERE ProductID = " . $infonum;
       echo "<table align = 'left' width = '100%'><tr><th><b><i>NAME</b></i></th><th><b><i>DESCRIPTION</b></i></th><th><b><i>PRICE</b></i></th><th><b><i>IMAGE</b></i></th></tr>";
       $result = $con->query($sql);
         if (mysqli_num_rows($result) > 0) {
                          //  $infonum = $result[1];        
                            list($infoname, $infordesc, $infoprice, $infoimage) = mysqli_fetch_row($result);
                            echo"<tr>";
                            //show this information in table cells
                            echo "<td align=\"left\" width=\"450px\">$infoname</td><br>";
                            echo "<td align=\"center\">Item Description: $infordesc</td><br>";
                            echo "<td align=\"right\" width=\"325px\">Item Price: " . money_format('%(#8n', $infoprice) . "</td><br>";
                           
                            echo "<td align=\"right\" width=\"450px\"><img src='productImages\\$infoimage' height=\"160\" width=\160\"></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                }
                ?>
            </div>
            <div>
                <?php
                    if ($_SESSION['cart']) {//if the cart isn't empty
                        //show the cart
                        echo "<table border=\"1\" padding=\"3\" width=\"640px\"><tr><th>Name</th><th>Desc</th><th>Price</th></tr>"; //format the cart using a HTML table
                        //Iterate through the cart, the $product_id id the key and $quantity is the value
                        foreach ($_SESSION['cart'] as $product_id => $quantity) { //if the cart isnt empty
                            $sql = "SELECT `Name`, `Description`, Price FROM CSIS2440.Ecommerce WHERE ProductID = " . $product_id;
                            //echo $sql;
                            $result = $con->query($sql);
                            //Only display teh row if there is a product(through there should always be as we have already checked)
                            if (mysqli_num_rows($result) > 0) {
                                list($name, $desc, $price) = mysqli_fetch_row($result);

                                $line_cost = $price * $quantity; //workout the lie of cost

                                $total = $total + $line_cost; //add to total cost
                                echo "<tr>";
                                //show this information in table cells
                                echo "<td align = \"left\" width = \"450px\">$name</td>";
                                echo "<td align = \"center\" width = \"75px\">$desc</td>";
                                echo "<td align = \"center\" width = \"75px\">" . money_format('%(#8n', $price) . "</td>";
                                //echo "<td align = \"center\">" . money_format('%(#8n', $line_cost) . "</td>";
                                echo "</tr>";
                            }
                        }
                        //show the total
                        echo "<tr>";
                        echo "<td align=\"right\">Total</td>";
 echo "<td align=\"right\"></td>";
                        echo "<td align = \"right\">" . money_format('%(#8n', $total) . "</td>";
                        echo "</tr>";
                        echo "</table>";
                    } else {
                        //otherwise tell the user they have no items in their cart
                        echo "You have no items in your shopping cart.";
                    }
                    mysqli_close($con)
                    ?>
            </div>
        </div>
        </form>
        
    </body>
        
<?php
include 'Footer.php';
?>
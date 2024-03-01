<html>

<?php
    if  (isset($_POST["submit-btn"])) {
        echo "<div>";
        echo "<p> Hello {$_POST["username"]} your password is {$_POST["password"]}!</p>";
        echo "</div>";
    } else {
        echo "Please enter your data into <a href='lab4.html'>this form</a>";
    }


?>

</html>
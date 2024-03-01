<html>

<head>
    
</head>

<?php
    if  (isset($_POST["email-btn"])) {
        echo "<div>";
        echo "<p> Thank you, please check your email! </p>";
        echo "</div>";
    } else {
        echo "Please enter your data into <a href='lab4.html'>this form</a>";
    }
?>

<body>
    <form method="post" action="lab4.html">
        <input type="submit" name="login-page-btn"
        value="Back to Login">
    </form>
</body>


</html>
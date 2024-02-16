<?php
//∗ checks whether auser has a ? after the file name 
// - used todetermine which page to load

//NOTE: this is a self−referencing structure , so <a> tags must a ”?” and the 
//appropriate value in the URL ∗/

if (empty($_SERVER['QUERY_STRING'])) { // load main page on first use
    $name="main";
}   else {
    $name=basename ($_SERVER['QUERY_STRING']); // load whatever was indicated after the ? in the URL
}

// this is the .php file we want to display
$file=$name.".php";

// assuming the file exists (it should : barring typo, or user error)
if (is_readable($file)) { // MODIFY THIS USING YOUR HTML/CSS/PHP LAB KNOWLEDGE! !
// banner and navigation bar code / divs here

// split main area into 2 columns (content and list of recent users ) /divs

include($file); // use this to include and execute an external php $file

// code or include(s) for the right /divs goes here

// optional: add footer div here
}   else {
    header("HTTP/1.0 404 Not Found"); // tell the user they are requesting an unknown file
    exit ;
}
?>
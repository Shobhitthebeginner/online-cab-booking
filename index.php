<div class="jumbotron">
    <h1 class="text-center">Home Page</h1>
</div>


<?php
include("header.php");
include("init.php");


$sql = "SELECT * FROM customer";
$result = query($sql);

confirm($result);
    
$row = fetch_array($result);

echo $row['username'];

?>

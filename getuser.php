<!DOCTYPE html>
<html>

<body>

<?php
#$q = intval($_GET['q']);
$q = $_GET['q'];

$servername = 'localhost:3306';
$username = 'sysadmin';
$passwordu = 'sysadmin';

$con = new mysqli($servername, $username, $passwordu);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'utickets');
$sql="SELECT * FROM users WHERE email = '".$q."'";
$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
    echo "Welcome, " . $row['name'];
}
mysqli_close($con);
?>
</body>
</html>
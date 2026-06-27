<?php
session_start();
include("includes/config.php");

if(!isset($_SESSION["user_id"]))
{
    header("Location:login.php");
    exit();
}

$search = "";
$department = "";
$semester = "";

$sql = "SELECT * FROM users WHERE id != ".$_SESSION["user_id"];

if(isset($_GET['search']))
{

$search = mysqli_real_escape_string($conn,$_GET['search']);
$department = mysqli_real_escape_string($conn,$_GET['department']);
$semester = mysqli_real_escape_string($conn,$_GET['semester']);

if($search!="")
{
$sql .= " AND full_name LIKE '%$search%'";
}

if($department!="")
{
$sql .= " AND department='$department'";
}

if($semester!="")
{
$sql .= " AND semester='$semester'";
}

}

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Find Students</title>

<link rel="stylesheet" href="css/search.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<h1>

Find Students

</h1>

<form method="GET" class="search-box">

<input
type="text"
name="search"
placeholder="Search by Name"
value="<?php echo $search; ?>">

<select name="department">

<option value="">All Departments</option>

<option value="CSE">CSE</option>

<option value="ECE">ECE</option>

<option value="EEE">EEE</option>

<option value="IT">IT</option>

<option value="MECH">MECH</option>

<option value="CIVIL">CIVIL</option>

</select>

<select name="semester">

<option value="">Semester</option>

<?php

for($i=1;$i<=8;$i++)
{

echo "<option value='$i'>$i</option>";

}

?>

</select>

<button>

Search

</button>

</form>

<div class="students">

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="student-card">

<img src="uploads/<?php echo $row['profile_photo']; ?>">

<h2>

<?php echo $row['full_name']; ?>

</h2>

<p>

<?php echo $row['department']; ?>

</p>

<p>

Semester

<?php echo $row['semester']; ?>

</p>

<p>

<?php

if($row['skills']=="")
echo "Skills Not Updated";

else
echo $row['skills'];

?>

</p>

<a href="student.php?id=<?php echo $row['id']; ?>">

View Profile

</a>

</div>

<?php

}

?>

</div>

</div>

</body>

</html>
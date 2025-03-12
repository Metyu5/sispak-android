<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bettafish";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE BINARY email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];  

    // Mengembalikan fullname dan role dalam format JSON
    echo json_encode(array("username" => $username, "email" => $row['email']));
} else {
    // Jika full_name dan password tidak cocok
    echo json_encode(array("message" => "invalid credentials"));
}

$conn->close();
?>

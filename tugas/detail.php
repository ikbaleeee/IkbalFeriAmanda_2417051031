<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    header("Location: auth.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: dashboard.php");
    exit();
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail User</title>
</head>
<body>

<h2>Detail User</h2>

<p>ID : <?php echo $user['id']; ?></p>
<p>Nama : <?php echo $user['nama']; ?></p>
<p>Role : <?php echo $user['role']; ?></p>

<a href="dashboard.php">
    <button>Kembali</button>
</a>

</body>
</html>
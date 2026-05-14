<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    header("Location: auth.php");
    exit();
}

if (isset($_GET['hapus'])) {

    if ($_SESSION['role'] == "admin") {

        $id = $_GET['hapus'];

        $hapus = $conn->prepare("DELETE FROM users WHERE id = ?");
        $hapus->bind_param("i", $id);

        $hapus->execute();

        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Dashboard</h2>

<h3>
Selamat Datang,
<?php echo htmlspecialchars($_SESSION['nama']); ?>
</h3>

<a href="logout.php">
    <button>Logout</button>
</a>

<hr>

<?php if ($_SESSION['role'] == "admin") : ?>

<h3>Manajemen User</h3>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

<?php

$data = $conn->query("SELECT * FROM users");

while ($row = $data->fetch_assoc()) :

?>

<tr>

    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['nama']; ?></td>
    <td><?php echo $row['role']; ?></td>

    <td>

        <a href="detail.php?id=<?php echo $row['id']; ?>">
            <button>Detail</button>
        </a>

        <a href="edit.php?id=<?php echo $row['id']; ?>">
            <button>Edit</button>
        </a>

        <a href="dashboard.php?hapus=<?php echo $row['id']; ?>">
            <button>Hapus</button>
        </a>

    </td>

</tr>

<?php endwhile; ?>

</table>

<?php endif; ?>

</body>
</html>
<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    header("Location: auth.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    header("Location: dashboard.php");
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

if (isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $update = $conn->prepare("
        UPDATE users
        SET nama = ?, password = ?, role = ?
        WHERE id = ?
    ");

    $update->bind_param("sssi", $nama, $hash, $role, $id);

    if ($update->execute()) {

        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<form method="POST">

    <input
        type="text"
        name="nama"
        value="<?php echo $user['nama']; ?>"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password Baru"
        required
    >

    <br><br>

    <select name="role">

        <option value="user"
        <?php if($user['role']=="user") echo "selected"; ?>>
            User
        </option>

        <option value="admin"
        <?php if($user['role']=="admin") echo "selected"; ?>>
            Admin
        </option>

    </select>

    <br><br>

    <button type="submit" name="update">
        Update
    </button>

</form>

</body>
</html>
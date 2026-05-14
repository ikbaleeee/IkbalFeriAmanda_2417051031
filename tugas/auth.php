<?php
session_start();
require 'koneksi.php';

$pesan = "";

if (isset($_SESSION['nama'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // REGISTER
    if (isset($_POST['register'])) {

        $nama = trim($_POST['nama']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($nama) || empty($password)) {

            $pesan = "Semua field wajib diisi";

        } elseif (strlen($password) < 8) {

            $pesan = "Password minimal 8 karakter";

        } else {

            $cek = $conn->prepare("SELECT id FROM users WHERE nama = ?");
            $cek->bind_param("s", $nama);
            $cek->execute();
            $cek->store_result();

            if ($cek->num_rows > 0) {

                $pesan = "Username sudah digunakan";

            } else {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (nama,password,role) VALUES (?,?,?)");
                $stmt->bind_param("sss", $nama, $hash, $role);

                if ($stmt->execute()) {
                    $pesan = "Registrasi berhasil";
                } else {
                    $pesan = "Registrasi gagal";
                }
            }
        }
    }

    // LOGIN
    if (isset($_POST['login'])) {

        $nama = trim($_POST['nama']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE nama = ?");
        $stmt->bind_param("s", $nama);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
                exit();

            } else {

                $pesan = "Password salah";
            }

        } else {

            $pesan = "User tidak ditemukan";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login & Register</title>
</head>
<body>

<h2>FORM LOGIN & REGISTER</h2>

<?php
if ($pesan != "") {
    echo "<p>$pesan</p>";
}
?>

<h3>Register</h3>

<form method="POST">

    <input type="text" name="nama" placeholder="Nama" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <br><br>

    <button type="submit" name="register">Register</button>

</form>

<hr>

<h3>Login</h3>

<form method="POST">

    <input type="text" name="nama" placeholder="Nama" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit" name="login">Login</button>

</form>

</body>
</html>
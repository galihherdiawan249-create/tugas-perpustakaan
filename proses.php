<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form.php");
    exit;
}

$no_anggota    = isset($_POST["no_anggota"]) ? trim($_POST["no_anggota"]) : "";
$nama_lengkap  = isset($_POST["nama_lengkap"]) ? trim($_POST["nama_lengkap"]) : "";
$email         = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$no_hp         = isset($_POST["no_hp"]) ? trim($_POST["no_hp"]) : "";
$jenis_anggota = isset($_POST["jenis_anggota"]) ? trim($_POST["jenis_anggota"]) : "";
$alamat        = isset($_POST["alamat"]) ? trim($_POST["alamat"]) : "";

$daftar_jenis  = array("Mahasiswa", "Dosen", "Tenaga Kependidikan");
$err           = array();

// Validasi input
if (empty($no_anggota)) {
    $err['no_anggota'] = "Nomor anggota tidak boleh kosong.";
} elseif (!ctype_digit($no_anggota)) {
    $err['no_anggota'] = "Nomor anggota hanya boleh berisi angka.";
} elseif (strlen($no_anggota) > 15) {
    $err['no_anggota'] = "Nomor anggota maksimal 15 digit.";
}

if (empty($nama_lengkap)) {
    $err['nama_lengkap'] = "Nama lengkap tidak boleh kosong.";
} elseif (strlen($nama_lengkap) > 100) {
    $err['nama_lengkap'] = "Nama lengkap maksimal 100 karakter.";
}

if (empty($email)) {
    $err['email'] = "Email tidak boleh kosong.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err['email'] = "Format email tidak valid.";
} elseif (strlen($email) > 100) {
    $err['email'] = "Email maksimal 100 karakter.";
}

if (empty($no_hp)) {
    $err['no_hp'] = "Nomor HP tidak boleh kosong.";
} elseif (!ctype_digit($no_hp)) {
    $err['no_hp'] = "Nomor HP hanya boleh berisi angka.";
} elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
    $err['no_hp'] = "Nomor HP harus berukuran 10 sampai 13 digit.";
}

if (empty($jenis_anggota)) {
    $err['jenis_anggota'] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, $daftar_jenis, true)) {
    $err['jenis_anggota'] = "Jenis anggota tidak valid.";
}

if (empty($alamat)) {
    $err['alamat'] = "Alamat tidak boleh kosong.";
}

if (!empty($err)) {
    $_SESSION["err"] = $err;
    $_SESSION["old"] = $_POST;
    header("Location: form.php");
    exit;
}

require_once "koneksi.php";

$sql = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssss", $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($koneksi);
        header("Location: form.php?status=sukses");
        exit;
    } else {
        $db_error = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($koneksi);
        die("Gagal menyimpan ke database: " . htmlspecialchars($db_error));
    }
} else {
    mysqli_close($koneksi);
    die("Gagal menyiapkan statement: " . htmlspecialchars(mysqli_error($koneksi)));
}
?>
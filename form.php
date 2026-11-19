<?php
session_start();
$status = isset($_GET["status"]) ? $_GET["status"] : "";

$old = isset($_SESSION["old"]) ? $_SESSION["old"] : array();
$err = isset($_SESSION["err"]) ? $_SESSION["err"] : array();

unset($_SESSION["old"]);
unset($_SESSION["err"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Anggota Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #1f3864; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type="text"], select, textarea { width: 350px; padding: 6px; }
        button { margin-top: 16px; padding: 8px 20px; }
        .sukses { background: #e6f4ea; border-left: 5px solid #2e7d32; padding: 10px; width: 350px; color: #2e7d32; }
        .error-msg { color: #c0392b; font-size: 13px; margin-top: 4px; display: block; }
    </style>
</head>
<body>
    <h1>Pendaftaran Anggota Perpustakaan</h1>

    <?php if ($status === "sukses") { ?>
        <p class="sukses">Pendaftaran anggota berhasil disimpan.</p>
    <?php } ?>

    <form action="proses.php" method="post">
        <label for="no_anggota">Nomor Anggota</label>
        <input type="text" id="no_anggota" name="no_anggota" value="<?php echo isset($old['no_anggota']) ? htmlspecialchars($old['no_anggota']) : ''; ?>">
        <?php if (!empty($err['no_anggota'])) { echo '<span class="error-msg">' . $err['no_anggota'] . '</span>'; } ?>

        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo isset($old['nama_lengkap']) ? htmlspecialchars($old['nama_lengkap']) : ''; ?>">
        <?php if (!empty($err['nama_lengkap'])) { echo '<span class="error-msg">' . $err['nama_lengkap'] . '</span>'; } ?>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?php echo isset($old['email']) ? htmlspecialchars($old['email']) : ''; ?>">
        <?php if (!empty($err['email'])) { echo '<span class="error-msg">' . $err['email'] . '</span>'; } ?>

        <label for="no_hp">Nomor HP</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo isset($old['no_hp']) ? htmlspecialchars($old['no_hp']) : ''; ?>">
        <?php if (!empty($err['no_hp'])) { echo '<span class="error-msg">' . $err['no_hp'] . '</span>'; } ?>

        <label for="jenis_anggota">Jenis Anggota</label>
        <select id="jenis_anggota" name="jenis_anggota">
            <option value="">-- Pilih Jenis Anggota --</option>
            <option value="Mahasiswa" <?php echo (isset($old['jenis_anggota']) && $old['jenis_anggota'] === 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
            <option value="Dosen" <?php echo (isset($old['jenis_anggota']) && $old['jenis_anggota'] === 'Dosen') ? 'selected' : ''; ?>>Dosen</option>
            <option value="Tenaga Kependidikan" <?php echo (isset($old['jenis_anggota']) && $old['jenis_anggota'] === 'Tenaga Kependidikan') ? 'selected' : ''; ?>>Tenaga Kependidikan</option>
        </select>
        <?php if (!empty($err['jenis_anggota'])) { echo '<span class="error-msg">' . $err['jenis_anggota'] . '</span>'; } ?>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="4"><?php echo isset($old['alamat']) ? htmlspecialchars($old['alamat']) : ''; ?></textarea>
        <?php if (!empty($err['alamat'])) { echo '<span class="error-msg">' . $err['alamat'] . '</span>'; } ?>

        <br>
        <button type="submit">Daftar</button>
    </form>
</body>
</html>
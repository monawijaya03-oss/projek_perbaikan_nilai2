<?php

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$error = $error ?? '';
$old = $old ?? [
    'kode' => '', 'nama' => '', 'prodi' => '',
    'semester' => '', 'sks' => '', 'status' => 'Aktif'
];
$prodi = $old['prodi'];
$status = $old['status'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #1e3a8a;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .radio-group {
            margin-top: 10px;
        }

        .radio-group input {
            width: auto;
        }

        .radio-group label {
            display: inline;
            font-weight: normal;
            margin-right: 20px;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .kembali {
            display: inline-block;
            margin-top: 15px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Mata Kuliah</h1>

    <?php if ($error !== ''): ?>
        <div class="error"><?= e($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=create" method="POST">

        <label>Kode Mata Kuliah</label>
        <input type="text" name="kode"
               placeholder="Contoh: SKA-0309"
               value="<?= e($old['kode']) ?>"
               maxlength="20" required>

        <label>Nama Mata Kuliah</label>
        <input type="text" name="nama"
               placeholder="Masukkan nama mata kuliah"
               value="<?= e($old['nama']) ?>"
               maxlength="100" required>

        <label>Program Studi</label>

        <select name="prodi" required>
            <option value="">-- Pilih Program Studi --</option>

            <option value="D3 Komputerisasi Akuntansi" <?= ($prodi == 'D3 Komputerisasi Akuntansi') ? 'selected' : '' ?>>
                D3 Komputerisasi Akuntansi
            </option>

            <option value="S1 Sistem Informasi" <?= ($prodi == 'S1 Sistem Informasi') ? 'selected' : '' ?>>
                S1 Sistem Informasi
            </option>

            <option value="S1 Rekayasa Perangkat Lunak" <?= ($prodi == 'S1 Rekayasa Perangkat Lunak') ? 'selected' : '' ?>>
                S1 Rekayasa Perangkat Lunak
            </option>
        </select>

        <label>Semester</label>
        <input type="number" name="semester"
               min="1" max="8"
               placeholder="Semester 1-8"
               value="<?= e($old['semester']) ?>" required>

        <label>SKS</label>
        <input type="number" name="sks"
               min="1" max="6"
               placeholder="Jumlah SKS 1-6"
               value="<?= e($old['sks']) ?>" required>

        <label>Status Mata Kuliah</label>

        <div class="radio-group">

            <input type="radio" id="aktif"
                   name="status" value="Aktif"
                   <?= ($status == 'Aktif') ? 'checked' : '' ?> required>

            <label for="aktif">Aktif</label>

            <input type="radio" id="tidak_aktif"
                   name="status" value="Tidak Aktif"
                   <?= ($status == 'Tidak Aktif') ? 'checked' : '' ?>>

            <label for="tidak_aktif">Tidak Aktif</label>

        </div>

        <button type="submit">Simpan Data</button>

    </form>

    <a href="index.php" class="kembali">← Kembali ke halaman utama</a>

</div>

</body>
</html>
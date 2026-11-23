<?php
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #1e3a8a;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            margin-bottom: 15px;
        }

        .tambah {
            background: #2563eb;
        }

        .edit {
            background: #f59e0b;
        }

        .hapus {
            background: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
        }

        .badge-success {
            background: #16a34a;
        }

        .badge-danger {
            background: #dc2626;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .pesan {
            background: #dcfce7;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            color: #166534;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Sistem Manajemen Data Mata Kuliah</h1>

    <p>Daftar seluruh mata kuliah yang tersimpan.</p>

    <?php if (isset($_GET['msg'])): ?>
        <div class="pesan">
            <?php
            $pesan = [
                'created' => 'Data berhasil ditambahkan!',
                'updated' => 'Data berhasil diperbarui!',
                'deleted' => 'Data berhasil dihapus!'
            ];

            echo e($pesan[$_GET['msg']] ?? '');
            ?>
        </div>
    <?php endif; ?>

    <a href="index.php?action=create" class="btn tambah">
        + Tambah Mata Kuliah
    </a>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>Program Studi</th>
                <th>Semester</th>
                <th>SKS</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if (!empty($mata_kuliah)): ?>

            <?php $no = 1; ?>

            <?php foreach ($mata_kuliah as $row): ?>

                <tr>
                    <td><?= $no++ ?></td>

                    <td><?= e($row['KodeMataKuliah']) ?></td>

                    <td><?= e($row['NamaMataKuliah']) ?></td>

                    <td><?= e($row['ProgramStudi']) ?></td>

                    <td><?= e($row['Semester']) ?></td>

                    <td><?= e($row['SKS']) ?></td>

                    <td>
                        <?php if ($row['Status'] == 'Aktif'): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Tidak Aktif</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="index.php?action=edit&id=<?= e($row['IdMataKuliah']) ?>"
                           class="btn edit">Edit</a>

                        <a href="index.php?action=delete&id=<?= e($row['IdMataKuliah']) ?>"
                           class="btn hapus"
                           onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="8">Belum ada data mata kuliah.</td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>
    </div>

</div>

</body>
</html>
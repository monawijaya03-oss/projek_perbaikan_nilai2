<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/MataKuliah.php';

class MataKuliahController
{
    private $model;

    private $daftarProdi = [
        'D3 Komputerisasi Akuntansi',
        'S1 Sistem Informasi',
        'S1 Rekayasa Perangkat Lunak'
    ];

    public function __construct()
    {
        $database = new Database();
        $pdo = $database->getConnection();

        $this->model = new MataKuliah($pdo);
    }

    // Mengambil & membersihkan input dari form
    private function ambilInput()
    {
        return [
            'kode'     => trim($_POST['kode'] ?? ''),
            'nama'     => trim($_POST['nama'] ?? ''),
            'prodi'    => trim($_POST['prodi'] ?? ''),
            'semester' => trim($_POST['semester'] ?? ''),
            'sks'      => trim($_POST['sks'] ?? ''),
            'status'   => trim($_POST['status'] ?? '')
        ];
    }

    // Validasi sisi server (selain atribut required HTML5)
    private function validasi($d)
    {
        $errors = [];

        if ($d['kode'] === '' || strlen($d['kode']) > 20) {
            $errors[] = 'Kode mata kuliah wajib diisi (maksimal 20 karakter).';
        }
        if ($d['nama'] === '' || strlen($d['nama']) > 100) {
            $errors[] = 'Nama mata kuliah wajib diisi (maksimal 100 karakter).';
        }
        if (!in_array($d['prodi'], $this->daftarProdi, true)) {
            $errors[] = 'Program studi tidak valid.';
        }
        if (!ctype_digit($d['semester']) || $d['semester'] < 1 || $d['semester'] > 8) {
            $errors[] = 'Semester harus berupa angka 1 sampai 8.';
        }
        if (!ctype_digit($d['sks']) || $d['sks'] < 1 || $d['sks'] > 6) {
            $errors[] = 'SKS harus berupa angka 1 sampai 6.';
        }
        if (!in_array($d['status'], ['Aktif', 'Tidak Aktif'], true)) {
            $errors[] = 'Status mata kuliah tidak valid.';
        }

        return $errors;
    }

    // Menerjemahkan PDOException menjadi pesan yang aman untuk pengguna
    private function pesanDb(PDOException $e)
    {
        if ($e->getCode() === '23000') {
            return 'Kode atau Nama Mata Kuliah sudah terdaftar. Gunakan data yang berbeda.';
        }

        error_log($e->getMessage());
        return 'Terjadi kesalahan pada database. Silakan coba lagi.';
    }

    // Menampilkan seluruh data
    public function index()
    {
        $mata_kuliah = $this->model->getAll();

        require_once __DIR__ . '/../views/index.php';
    }

    // Menambahkan data
    public function create()
    {
        $error = '';
        $old = [
            'kode' => '', 'nama' => '', 'prodi' => '',
            'semester' => '', 'sks' => '', 'status' => 'Aktif'
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $this->ambilInput();
            $errors = $this->validasi($old);

            if (empty($errors)) {
                try {
                    $this->model->create($old);

                    header('Location: index.php?msg=created');
                    exit;
                } catch (PDOException $e) {
                    $error = $this->pesanDb($e);
                }
            } else {
                $error = implode(' ', $errors);
            }
        }

        require_once __DIR__ . '/../views/create.php';
    }

    // Mengedit data
    public function edit()
    {
        $id = $_GET['id'] ?? '';

        if (!ctype_digit((string) $id)) {
            die('ID tidak valid!');
        }

        // Ambil data berdasarkan ID
        $mk = $this->model->getById($id);

        if (!$mk) {
            die('Data mata kuliah tidak ditemukan!');
        }

        $error = '';

        // Proses penyimpanan perubahan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->ambilInput();
            $errors = $this->validasi($data);

            if (empty($errors)) {
                try {
                    $this->model->update($id, $data);

                    header('Location: index.php?msg=updated');
                    exit;
                } catch (PDOException $e) {
                    $error = $this->pesanDb($e);
                }
            } else {
                $error = implode(' ', $errors);
            }

            // Pertahankan isian pengguna saat terjadi error
            $mk['KodeMataKuliah'] = $data['kode'];
            $mk['NamaMataKuliah'] = $data['nama'];
            $mk['ProgramStudi']   = $data['prodi'];
            $mk['Semester']       = $data['semester'];
            $mk['SKS']            = $data['sks'];
            $mk['Status']         = $data['status'];
        }

        // Tampilkan halaman edit
        require_once __DIR__ . '/../views/edit.php';
    }

    // Menghapus data
    public function delete()
    {
        $id = $_GET['id'] ?? '';

        if (!ctype_digit((string) $id)) {
            die('ID tidak valid!');
        }

        try {
            $this->model->delete($id);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die('Gagal menghapus data.');
        }

        header('Location: index.php?msg=deleted');
        exit;
    }
}

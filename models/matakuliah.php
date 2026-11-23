<?php

class MataKuliah
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Menampilkan semua data mata kuliah
    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM mata_kuliah ORDER BY IdMataKuliah DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data berdasarkan ID
    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM mata_kuliah WHERE IdMataKuliah = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan data mata kuliah
    public function create($data)
    {
        $sql = "INSERT INTO mata_kuliah
                (KodeMataKuliah, NamaMataKuliah, ProgramStudi,
                 Semester, SKS, Status)
                VALUES (:kode, :nama, :prodi, :semester, :sks, :status)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':kode' => $data['kode'],
            ':nama' => $data['nama'],
            ':prodi' => $data['prodi'],
            ':semester' => $data['semester'],
            ':sks' => $data['sks'],
            ':status' => $data['status']
        ]);
    }

    // Mengubah data mata kuliah
    public function update($id, $data)
    {
        $sql = "UPDATE mata_kuliah SET
                KodeMataKuliah = :kode,
                NamaMataKuliah = :nama,
                ProgramStudi = :prodi,
                Semester = :semester,
                SKS = :sks,
                Status = :status
                WHERE IdMataKuliah = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':kode' => $data['kode'],
            ':nama' => $data['nama'],
            ':prodi' => $data['prodi'],
            ':semester' => $data['semester'],
            ':sks' => $data['sks'],
            ':status' => $data['status']
        ]);
    }

    // Menghapus data mata kuliah
    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM mata_kuliah WHERE IdMataKuliah = ?"
        );

        return $stmt->execute([$id]);
    }
}
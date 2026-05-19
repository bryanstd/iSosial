<?php
namespace App\Models;

class KegiatanModel
{
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../Config/Database.php';
        $this->db = isosial_db_connection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM isosial_kegiatan ORDER BY tanggal_mulai ASC";
        $result = $this->db->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM isosial_kegiatan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        return $res->fetch_assoc();
    }

    public function create($nama, $lokasi, $mulai, $selesai, $gambar)
    {
        $stmt = $this->db->prepare("
            INSERT INTO isosial_kegiatan (nama_kegiatan, lokasi, tanggal_mulai, tanggal_selesai, gambar)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssss", $nama, $lokasi, $mulai, $selesai, $gambar);

        return $stmt->execute();
    }

    public function update($id, $nama, $lokasi, $mulai, $selesai, $gambar = null)
    {
        if ($gambar !== null) {
            $stmt = $this->db->prepare("
                UPDATE isosial_kegiatan 
                SET nama_kegiatan=?, lokasi=?, tanggal_mulai=?, tanggal_selesai=?, gambar=? 
                WHERE id=?
            ");
            $stmt->bind_param("sssssi", $nama, $lokasi, $mulai, $selesai, $gambar, $id);
        } else {
            $stmt = $this->db->prepare("
                UPDATE isosial_kegiatan 
                SET nama_kegiatan=?, lokasi=?, tanggal_mulai=?, tanggal_selesai=? 
                WHERE id=?
            ");
            $stmt->bind_param("ssssi", $nama, $lokasi, $mulai, $selesai, $id);
        }

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM isosial_kegiatan WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
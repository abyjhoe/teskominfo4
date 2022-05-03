<?php

class setting
{

    protected $dbsetup = null;
    protected $koneksi = null;
    protected $sql = null;

    function beginTransaction()
    {
        return $this->koneksi->beginTransaction();
    }

    function lastInsertId()
    {
        return $this->koneksi->lastInsertId();
    }

    function commit()
    {
        return $this->koneksi->commit();
    }

    function rollBack()
    {
        return $this->koneksi->rollBack();
    }

    function fetchColumn()
    {
        return $this->sql->fetchColumn();
    }
}


//============proses data====================//
class Db extends setting
{
    function __construct($dbsetup)
    {
        $this->dbsetup = $dbsetup;
    }

    function db()
    {

        $dbsetup = $this->dbsetup;
        if ($this->koneksi) return $this;
        try {
            $this->koneksi = new PDO("mysql:host=" . $dbsetup['host'] . ";dbname=" . $dbsetup['name'] . "", $dbsetup['user'], $dbsetup['pass']);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function st()
    {
        try {
            $this->sql->execute();
            return $this;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function countRegistration($data)
    {
        if ($data > 0) {
            $sql = "SELECT COUNT(`idpendaftar`) as total FROM `pendaftar`";
            $this->sql = $this->koneksi->prepare($sql);
            return $this;
        } else {
        }
    }

    function addRegistration($data)
    {
        try {
            $tahun = $data['tahun'];
            $bulan = $data['bulan'];
            $nik = $data['nik'];
            $nama = $data['nama'];
            $alamat = $data['alamat'];
            $surel = $data['surel'];

            $sql = "INSERT INTO `pendaftar`(`tahun`, `bulan`, `nik`, `nama`, `alamat`, `surel`) VALUES ('$tahun','$bulan','$nik','$nama','$alamat','$surel')";
            $sql = $this->koneksi->prepare($sql);

            $sql->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

<?php

namespace App\Models;

class Kegiatan
{
    public $kegiatanapa;
    public $tanggal;

    public function __construct($kegiatanapa, $tanggal)
    {
        $this->kegiatanapa = $kegiatanapa;
        $this->tanggal = $tanggal;
    }
}
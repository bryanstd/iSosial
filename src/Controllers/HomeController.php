<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        $arsip_kegiatan = [
            new Kegiatan('Penggalangan dana', '1 Januari 2026'),
            new Kegiatan('Bakti Sosial', '2 Januari 2026')
        ];
        $this->render('index', ['kegiatan' => $arsip_kegiatan]);
    }
}
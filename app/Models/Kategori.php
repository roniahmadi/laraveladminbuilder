<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    public function getField(){
        $data = [
            [
                "name" => "kode_barang",
                "alias_name" => "Kode Barang",
                "type" => "text",
                "value" => "",
                "attr" => ""
            ],
            [
                "name" => "nama_barang",
                "alias_name" => "Nama Barang",
                "type" => "text",
                "value" => "",
                "attr" => ""
            ],
            [
                "name" => "id_kategori",
                "alias_name" => "Kategori",
                "type" => "select",
                "value" => "",
                "attr" => ""
            ]
        ];
        return $data;
    }
}

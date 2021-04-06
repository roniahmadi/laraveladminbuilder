<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model{
    protected $append= ['ckategori'];
    public function kategoris(){
        return $this->hasOne(Kategori::class,'id');
    }
    public function getCkategoriAttribute(){
        return ($this->kategoris ? $this->kategoris->nama_kategori:$this->kategoris);
    }
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
                "name" => "ckategori",
                "alias_name" => "Kategori",
                "type" => "select",
                "value" => "",
                "attr" => ""
            ]
        ];
        return $data;
    }
}

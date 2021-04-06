<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang as B;

class Barang extends Controller
{
    function __construct(){
        $this->model_name = new B();
        $this->class_name = "Barang";
        $this->class = __CLASS__;
        parent::__construct();
    }
}

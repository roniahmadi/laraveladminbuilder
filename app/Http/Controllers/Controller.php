<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $class_name = "";
    public $class = "";
    public $url = "";
    public $model_name = null;
    public $fillable = [];

    public $list_view = "admin.listview";
    public $form_view = "admin.formview";

    public $paginate = 15;

    public function __construct(){
        if($this->model_name){
            $this->fillable = $this->model_name->getField();
        }
        $explode_string = explode("\\",$this->class);
        $splice_string = array_splice($explode_string,3,count($explode_string)-1);
        $this->url = implode('.',$splice_string);
    }

    public function index(){
        $context = $this->create_context();
        return view($this->list_view, $context);
    }

    public function add(){
        $context = $this->create_context();
        $context['title'] = "Tambah ".$this->class_name;
        return view($this->form_view, $context);
    }

    public function create_context(){
        $context = [
            'title' => 'List '.$this->class_name,
            'sub_title' => 'List '.$this->class_name,
            'name' => $this->class_name,
            'add' => true,
            'add_url' => route($this->url.'.add')
        ];
        $context['custom_action'] = false;
        $context['use_action'] = true;
        $context["field"] = $this->fillable;
        $context['data'] = $this->compile_data();
        return $context;
    }

    public function compile_data(){
        $data = $this->model_name->paginate($this->paginate);
        return $data;
    }
}

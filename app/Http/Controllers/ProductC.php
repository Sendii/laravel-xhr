<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product as Pr;

class ProductC extends Controller
{
    public function getData(){
    	$data = Pr::orderBy('id', 'ASC')->get();
    	return json_encode($data);
    }

    public function save(Request $r){
    	// $new = new Pr;
    	// $new->save($r->all());
    	Pr::forceCreate($r->all());
    	return json_encode(['message' => "success add", "code" => 0]);
    }

    public function update(Request $r){
        $edit = Pr::find($r->id);
        $edit->nama = $r->nama;
        $edit->harga = $r->harga;

        $edit->save();
        return json_encode(['message' => "success update", "code" => 0]);
    }

    public function delete(Request $r){
        $data = Pr::find($r->id);
        $data->delete();

        return json_encode(['message' => "success delete", "code" => 0]);        
    }
}

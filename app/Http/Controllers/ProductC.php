<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product as Pr;

class ProductC extends Controller
{
    public function getData(){
    	$data = Pr::all();
    	return json_encode($data);
    }

    public function save(Request $r){
    	// $new = new Pr;
    	// $new->save($r->all());
    	Pr::forceCreate($r->all());
    	return json_encode(['message' => "success", "code" => 0]);
    }
}

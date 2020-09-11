<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product as Pr;

class ProductC extends Controller
{
    public function getData(Request $r){
        $limit = 2;
        $total_data = Pr::count();
        $paging = $r->page;

        $total_data = $total_data / $limit;
        if ($paging == 0) {
        	$data = Pr::orderBy('id', 'ASC')->skip($paging)->take($limit)->get();
        }else{
            $data = Pr::orderBy('id', 'ASC')->skip($paging + 1)->take($limit)->get();
        }
        // $data = Pr::orderBy('id', 'ASC')->get();
    	return json_encode(['data' => $data, 'total_data' => $total_data]);
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
        if (!empty($data)) {
            $data->delete();
            return json_encode('success', 0);        
            # code...
        }else{
            return json_encode('failed', 0);        
        }

    }
}

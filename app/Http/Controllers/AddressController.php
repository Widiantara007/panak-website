<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function get_data(Request $request){
        $type = $request->type;
        $code = $request->code;
        $length = ($type == 'province' ? 2 : ($type == 'district' ? 5: ($type == 'sub-district' ? 8 : 13)));
        
        $data = Address::whereRaw('LEFT(`code`, '.strlen($code).') = "'.$code.'"')->whereRaw("CHAR_LENGTH(code) =".$length)->orderBy('name')->get();
		return response()->json($data);
    }
}

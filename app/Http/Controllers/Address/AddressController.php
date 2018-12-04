<?php

namespace App\Http\Controllers\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\AddressService;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->address = new AddressService;
    }

    public function create(Request $req)
    {
        $this->address->create([
            'id_user' => Auth::user()->id,
            'receiver_name' => $req->receiver_name,
            'number_tlp' => $req->number_tlp,
            'zip_code' => $req->zip_code,
            'province' => $req->province,
            'city' => $req->city,
            'region' => $req->region,
            'others' => $req->others,
        ]);

        return redirect()->back();
    }

    public function update(Request $req, $id)
    {
        $this->address->find($id)
        ->update([
            'id_user' => Auth::user()->id,
            'receiver_name' => $req->receiver_name,
            'number_tlp' => $req->number_tlp,
            'zip_code' => $req->zip_code,
            'province' => $req->province,
            'city' => $req->city,
            'region' => $req->region,
            'others' => $req->others,
        ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->address->find($id)->delete();

        return redirect()->back();
    }
}
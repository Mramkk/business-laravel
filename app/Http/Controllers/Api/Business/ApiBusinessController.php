<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\BusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBusinessController extends Controller
{
    public function data()
    {
        $data = BusinessDetails::where('user_id', auth()->user()->id)->get();
        if ($data != null) {
            return ApiRes::data($data);
        } else {
            return ApiRes::error();
        }
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|numeric|digits:10',
            'contect_person' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'address' => 'required|string|max:1000'

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return ApiRes::validatorError($errors);
        }

        $obj = new BusinessDetails();
        $obj->user_id = auth()->user()->id;
        $obj->name = $req->name;
        $obj->email = $req->email;
        $obj->phone = $req->phone_number;
        $obj->contect_person = $req->contect_person;
        $obj->website = $req->website;
        $obj->address = $req->address;
        $status = $obj->save();
        if ($status) {
            return  ApiRes::success('Data save successfully !');
        } else {
            return  ApiRes::error();
        }
    }
}

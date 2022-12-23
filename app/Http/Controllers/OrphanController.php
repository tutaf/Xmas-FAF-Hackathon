<?php

namespace App\Http\Controllers;

use App\Models\Orphan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrphanController extends Controller
{
    public function getAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error', $validator->errors()->first(), []);
        }

        $data = Orphan::all();
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphans not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphans' => $data
        ]);

    }

    public function getOrphanById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error', $validator->errors()->first(), []);
        }

        $data = Orphan::find($request->id);


        return $this->sendResponse(200, 'success', 'Success', [
            'orphan' => $data
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Orphan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrphanController extends Controller
{
    public function getAll($id, Request $request)
    {
        $data = Orphan::where('orphan_building_id', $id)->get();
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphans not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphans' => $data
        ]);

    }

    public function getOrphanById($id, Request $request)
    {

        $data = Orphan::find($id);
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphan not found',[]);
        }

        return $this->sendResponse(200, 'success', 'Success', [
            'orphan' => $data
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Orphan;
use App\Models\OrphanBuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrphanBuildingController extends Controller
{
    public function getByLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error','Undefined location', []);
        }

        $data = OrphanBuilding::where('location', $request->location)->get();
        if (!$data) {
            return $this->sendResponse(404,'error', 'OrphanBuildings not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphanBuildings' => $data
        ]);

    }

    public function getOrphanById($id, Request $request)
    {

        $data = OrphanBuilding::find($id);
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphan not found',[]);
        }

        return $this->sendResponse(200, 'success', 'Success', [
            'orphan' => $data
        ]);
    }

    public function getAll(Request $request)
    {
        $data = OrphanBuilding::all();
        if (!$data) {
            return $this->sendResponse(404,'error', 'OrphanBuildings not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphanBuildings' => $data
        ]);
    }
}

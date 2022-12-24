<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Orphan;
use App\Models\OrphanBuilding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrphanBuildingController extends Controller
{

    public function createOrphanBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:orphan_buildings',
            'text' => 'required',
            'location' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error',$validator->errors()->first(), []);
        }

        $image_path = $request->file('image')->store('Orphan', 'public');

        $data = Image::create([
            'image' => $image_path,
        ]);

        if ($data) {
            $user = User::where('access_token', $request->access_token)->first();
            if($response = OrphanBuilding::create([
                'name' => $request->name,
                'text' => $request->text,
                'location' => $request->location,
                'image_id' => $data["id"],
                'user_id' => $user->id

            ])) {
                return $this->sendResponse(200, 'success', 'Success get', [
                    'orphanBuilding' => $response
                ]);
            }

            return $this->sendResponse(401, 'error', 'OrphanBuilding wasn\'t added', []);

        }

        return $this->sendResponse(401, 'error', 'Image wasn\'t uploaded', []);

    }

    public function getByLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error','Undefined location', []);
        }

        $data = OrphanBuilding::with('image')->where('location', 'like', '%'.$request->location.'%')->get();
        if (!$data) {
            return $this->sendResponse(404,'error', 'OrphanBuildings not found',[]);
        }

//        $arr = [];
//        foreach ($data as $orphan) {
//            $arr[] = [
//                    'data' =>
//                        ['name' => $orphan->name,
//                            'user_id' => $orphan->user_id,
//                            'text' => $orphan->text,
//                            'location' => $orphan->location],
//                    'image' => $orphan->image->image
//                    ];
//        }

        return $this->sendResponse(200, 'success', 'Success get', [
            'orphanBuildings' => $data,
        ]);

    }

    public function getOrphanById($id, Request $request)
    {

        $data = OrphanBuilding::with('image')->find($id);
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphan not found',[]);
        }

        return $this->sendResponse(200, 'success', 'Success', [
            'orphan' => $data,
        ]);
    }

    public function getAll(Request $request)
    {
        $data = OrphanBuilding::with('image')->get();
        if (!$data) {
            return $this->sendResponse(404,'error', 'OrphanBuildings not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphanBuildings' => $data,
        ]);
    }
}

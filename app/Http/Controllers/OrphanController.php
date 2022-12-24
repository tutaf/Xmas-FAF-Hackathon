<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Orphan;
use App\Models\OrphanBuilding;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrphanController extends Controller
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
                'text' => $request->test,
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

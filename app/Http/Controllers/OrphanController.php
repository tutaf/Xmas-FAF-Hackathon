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

    public function deleteOrphan($id)
    {

    }

    public function createOrphan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orphan_building_id' => 'required',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            'text' => 'string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error', $validator->errors()->first(), []);
        }

        $image_path = $request->file('image')->store('OrphanChild', 'public');

        $data = Image::create([
            'image' => $image_path,
        ]);

        if ($data) {
            $user = User::where('access_token', $request->access_token)->first();
            if($response = Orphan::create([
                'orphan_building_id' => $request->orphan_building_id,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'birthday' => $request->birthday,
                'text' => $request->text,
                'image_id' => $data["id"],

            ])) {
                return $this->sendResponse(200, 'success', 'Success get', [
                    'orphan' => $response
                ]);
            }

            return $this->sendResponse(401, 'error', 'OrphanBuilding wasn\'t added', []);

        }

        return $this->sendResponse(401, 'error', 'Image wasn\'t uploaded', []);

    }

    public function getAll($id, Request $request)
    {
        $data = Orphan::with('image')->where('orphan_building_id', $id)->get();
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphans not found',[]);
        }
        return $this->sendResponse(200, 'success', 'Success get', [
            'orphans' => $data
        ]);

    }

    public function getOrphanById($id, Request $request)
    {

        $data = Orphan::with('image')->find($id);
        if (!$data) {
            return $this->sendResponse(404,'error', 'Orphan not found',[]);
        }

        return $this->sendResponse(200, 'success', 'Success', [
            'orphan' => $data
        ]);
    }

}

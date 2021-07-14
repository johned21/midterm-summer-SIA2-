<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Exception;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function show(Asset $asset) {
        return response()->json($asset,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $assets = Asset::where('ml_id','like',"%$request->key%")
            ->orWhere('ml_server','like',"%$request->key%")->get();

        return response()->json($assets, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'ml_id' => 'integer',
            'ml_server' => 'integer',
            'in_game_name' => 'string|required',
            'rank' => 'string|required',
        ]);

        try {
            $asset = Asset::create($request->all());
            return response()->json($asset, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Asset $asset) {
        try {
            $asset->update($request->all());
            return response()->json($asset, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Asset $asset) {
        $asset->delete();
        return response()->json(['message'=>'Asset deleted.'],202);
    }

    public function index() {
        $assets = Asset::orderBy('ml_id')->get();
        return response()->json($assets, 200);
    }

}

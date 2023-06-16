<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'dir'   => 'required',
            'file'  => 'file|max:2048'
        ]);
        $validator->validate();

        $dir = $request->file->store('public/'.$request->dir);
        $dimension = getimagesize($request->file);
        $result = collect([
            'dir'           => Storage::url($dir),
            'dimensions'    => collect([
                'width'         => $dimension[0],
                'height'        => $dimension[1]
            ])
        ]);

        return $this->sendResponse($result, 'Success');
    }

    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'file'   => 'required'
        ]);
        $validator->validate();

        Storage::delete(str_replace('storage', 'public', $request->file));

        return $this->sendResponse([], 'Success');
    }
}

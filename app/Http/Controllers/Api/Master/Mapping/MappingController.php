<?php

namespace App\Http\Controllers\Api\Master\Mapping;

use App\Http\Controllers\Controller;
use App\Models\Mapping;
use Illuminate\Http\Request;

use Validator;

class MappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Mapping::query();

        return $this->sendResponse($this->getListData($data, $request), 'Success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        $data = Mapping::create($validator->validate());

        return $this->sendResponse($data, 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function show(Mapping $mapping)
    {
        $mapping->details;

        return $this->sendResponse($mapping, "Success");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapping $mapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapping $mapping)
    {
        //
    }
}

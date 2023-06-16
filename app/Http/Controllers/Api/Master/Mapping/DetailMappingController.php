<?php

namespace App\Http\Controllers\Api\Master\Mapping;

use App\Http\Controllers\Controller;
use App\Models\DetailMapping;
use App\Models\ImageMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'mapping_id'    => 'required|exists:App\Models\Mapping,id',
            'name'          => 'required',
            'image'         => 'required',
            'width'         => 'required',
            'height'        => 'required',
            'max_dimension' => 'required'
        ])->validate();

        $limit = 1;
        while (($request->width / $limit) >= $request->max_dimension || ($request->height / $limit) >= $request->max_dimension) {
            $limit += 0.2;
        }

        $dataRequest = array_merge($validator, [
            'width'     => $request->width / $limit,
            'height'    => $request->height / $limit,
        ]);

        $data = DetailMapping::create($dataRequest);

        return $this->sendResponse($data, 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailMapping  $detailMapping
     * @return \Illuminate\Http\Response
     */
    public function show(DetailMapping $detailMapping)
    {
        $detailMapping->images;

        return $this->sendResponse($detailMapping, 'Success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailMapping  $detailMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailMapping $detailMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailMapping  $detailMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailMapping $detailMapping)
    {
        $detailMapping->delete();

        return $this->sendResponse($detailMapping, 'Success');
    }

    public function store_detail(Request $request, DetailMapping $detailMapping)
    {
        $validator = Validator::make($request->detail, [
            '*.type'          => 'required',
            '*.name'          => 'required',
            '*.action'        => 'required|in:1,2',
            '*.action_id'     => 'required|numeric',
            '*.latLng'        => 'required'
        ])->validate();

        ImageMapping::where('detail_mapping_id', $detailMapping->id)->delete();

        foreach ($validator as $value) {
            $data = array_merge($value, [
                'detail_mapping_id' => $detailMapping->id
            ]);

            ImageMapping::create($data);
        }

        return $this->sendResponse(ImageMapping::where('detail_mapping_id', $detailMapping->id)->get(), 'Success');
    }

    public function update_default(DetailMapping $detailMapping)
    {
        DetailMapping::where('mapping_id', $detailMapping->mapping_id)->update(['is_default' => 0]);
        DetailMapping::whereId($detailMapping->id)->update(['is_default' => 1]);

        return $this->sendResponse($detailMapping, 'Success');
    }
}

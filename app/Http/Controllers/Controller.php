<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($errorMessage, $error = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $errorMessage,
        ];

        if(!empty($error)){
            $response['data'] = $error;
        }


        return response()->json($response, $code);
    }

    public function searchableColumns($columns, $value)
    {
        $data = "";

        foreach ($columns as $key => $column) {
            if ($key != 0) {
                $data .= 'OR '.$column.' LIKE "%'.$value.'%" ';
            } else {
                $data .= ''.$column.' LIKE "%'.$value.'%" ';
            }
        }

        return $data;
    }

    public function getListData($data, $request)
    {
        if ($request->search) {
            $data->whereRaw($this->searchableColumns($this->searchable, $request->search));
        }

        if ($request->sort && $request->direction) {
            $data->orderBy($request->sort, $request->direction);
        }

        if ($request->rows_per_page) {
            $success = $data->paginate($request->rows_per_page);
        } else {
            $success = $data->get();
        }

        return $success;
    }

    public function getDropdownData($data, $label = 'name', $id = 'id', $allData = false, $customField = null)
    {
        $success = $data->selectRaw(($allData ? "*, " : "").($customField ? $customField .", " : ""). $id . " as value, " .$label. " as label")->get();

        return $this->sendResponse($success, "Data berhasil ditampilkan");
    }

    public function convertUrl($file) {
        return str_replace('storage', 'public', $file);
    }
}

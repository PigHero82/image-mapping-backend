<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailMapping;
use App\Models\Product;

class DropdownController extends Controller
{
    public function mapping_action()
    {
        $data = collect([
            [
                'label' => "Tampilkan Produk",
                'value' => 1
            ],
            [
                'label' => "Tampilkan Mapping Lainnya",
                'value' => 2
            ]
        ]);

        return $this->sendResponse($data, "Data berhasil ditampilkan");
    }

    public function product()
    {
        return $this->getDropdownData(Product::query());
    }

    public function detail_mapping()
    {
        return $this->getDropdownData(DetailMapping::query(), 'name', 'id', true);
    }
}

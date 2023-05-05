<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create (Request $request) {
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');
        $storeId = $request->get('storeId');
        $image =  $request->file('image');
        $imageUrl = '';
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $imageUrl = '/storage/images/' . $filename;
        }

        if (!$name || !$description || !$price  || !$storeId || !$image) {
            return response()->json('Please enter all the information', 400);
        }

        $result = Product::query()->updateOrInsert([
            'name' => $name,
            'description' => $description,
            'image' => $imageUrl,
            'price' => $price,
            'storeId' => $storeId
        ]);

        if ($result) {
            return  response()->json('Success', 200);
        }

        return  response()->json('Faild response', 400);
    }

    public function getList (Request $request) {
        $result = Product::query()->get();
        return $result;
    }

    public function delete ($id) {
        if ($id) {
            $data = Product::query()->find($id);
            if ($data) {
                $result = Product::query()->where('id', $id)->delete();
                if ($result) {
                    return  response()->json('Success', 200);
                }
            }
        }

        return  response()->json('Faild response', 400);
    }

    public function show ($id) {
        if ($id) {
            $data = Product::query()->find($id);
            if ($data) {
                return  response()->json($data, 200);
            }
        }
        return  response()->json('Faild response', 400);
    }

    public function edit ($id, Request $request) {
        if ($id) {
            $oldData = Product::query()->find($id);
            if ($oldData) {
                $name = $request->get('name');
                $description = $request->get('description');
                $price = $request->get('price');
                $storeId = $request->get('storeId');
                $image =  $request->file('image');
                $imageUrl = '';
                if ($image) {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/images', $filename);
                    $imageUrl = '/storage/images/' . $filename;
                }

                if (!$name || !$description || !$price || !$storeId || !$image) {
                    return response()->json('Please enter all the information', 400);
                }

                $result = Product::query()->where('id', $id)->update([
                    'name' => $name,
                    'description' => $description,
                    'image' => $imageUrl,
                    'price' => $price,
                    'storeId' => $storeId
                ]);

                if ($result) {
                    $pathImage = explode('/', $oldData->image);
                    if ($pathImage && isset($pathImage[3])) {
                        Storage::delete('public/images/' . $pathImage[3]);
                    }

                    $dataNew = Product::query()->find($id);

                    return  response()->json($dataNew, 200);
                }
            }

            return  response()->json('Faild response', 400);
        }
    }

    private function Reponse ($data, $code) {
        $reponse = [
            'data' => $data,
            'code' => $code
        ];
        return response()->json($reponse, $code);
    }
}

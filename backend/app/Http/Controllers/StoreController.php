<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class StoreController extends Controller
{
    public function create (Request $request) {
        $name = $request->get('name');
        $description = $request->get('description');
        $address = $request->get('address');
        $phoneNumber = $request->get('phoneNumber');
        $userId = $request->get('userId');
        $image =  $request->file('image');
        try {
            $request->validate([
                'title' => 'required|unique:posts|max:255',
                'body' => 'required',
                'publish_at' => 'required|nullable|date',
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

        $imageUrl = '';
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $imageUrl = '/storage/images/' . $filename;
        }

        $result = Store::query()->updateOrInsert([
            'name' => $name,
            'description' => $description,
            'image' => $imageUrl,
            'address' => $address,
            'phoneNumber' => $phoneNumber,
            'userId' => $userId
        ]);

        if ($result) {
            return  response()->json('Success', 200);
        }

        return  response()->json('Faild response', 400);
    }

    public function getList ($id, Request $request) {
        if ($id) {
            $result = Store::query()->where('userId', $id)->paginate();
            return $result;
        }
        return [];
    }

    public function delete ($id) {
        if ($id) {
            $data = Store::query()->find($id);
            if ($data) {
                $result = Store::query()->where('id', $id)->delete();
                if ($result) {
                    return  response()->json('Success', 200);
                }
            }
        }

        return  response()->json('Faild response', 400);
    }

    public function show ($id) {
        if ($id) {
            $data = Store::query()->find($id);
            if ($data) {
                return  response()->json($data, 200);
            }
        }
        return  response()->json('Faild response', 400);
    }

    public function edit ($id, Request $request) {
        if ($id) {
            $oldData = Store::query()->find($id);
            if ($oldData) {
                $name = $request->get('name');
                $description = $request->get('description');
                $address = $request->get('address');
                $phoneNumber = $request->get('phoneNumber');
                $userId = $request->get('userId');
                $image =  $request->file('image');
                $imageUrl = '';
                if ($image) {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/images', $filename);
                    $imageUrl = '/storage/images/' . $filename;
                }

                if (!$name || !$description || !$address || !$phoneNumber || !$userId || !$image) {
                    return response()->json('Please enter all the information', 400);
                }

                $result = Store::query()->where('id', $id)->update([
                    'name' => $name,
                    'description' => $description,
                    'image' => $imageUrl,
                    'address' => $address,
                    'phoneNumber' => $phoneNumber,
                    'userId' => $userId
                ]);

                if ($result) {
                    $pathImage = explode('/', $oldData->image);
                    if ($pathImage && isset($pathImage[3])) {
                        Storage::delete('public/images/' . $pathImage[3]);
                    }

                    $dataNew = Store::query()->find($id);

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

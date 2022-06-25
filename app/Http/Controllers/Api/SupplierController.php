<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:suppliers',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->name;
        $supplier->photo = isset($image_url) ? '/' . $image_url : null;;
        $supplier->address = $request->address;
        $supplier->shopName = $request->shopName;
        $supplier->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Supplier::findOrFail($id);
        return response()->json($employee);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        if($request->newPhoto){
            $realPath = trim($supplier->photo, '/');
            @unlink($realPath);
            $position = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->newPhoto)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }

        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->shopName = $request->shopName;
        $supplier->phone = $request->phone;
        $supplier->photo = isset($image_url) ? '/' . $image_url : $supplier->photo;
        $supplier->address = $request->address;
        $supplier->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
    }
}

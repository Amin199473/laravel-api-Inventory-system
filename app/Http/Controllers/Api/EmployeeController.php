<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
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
            'email' => 'required|unique:employees',
            'phone' => 'required'
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }

        //save data into table employee
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;
        $employee->photo = isset($image_url) ? '/' . $image_url : null;
        $employee->joiningDate = $request->joiningDate;
        $employee->address = $request->address;
        $employee->Nid = $request->Nid;
        $employee->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
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
        $employee = Employee::findOrFail($id);

        if ($request->newPhoto) {
            $realPath = trim($employee->photo, '/');
            @unlink($realPath);
            $position = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->newPhoto)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->photo = isset($image_url) ? '/' . $image_url : $employee->photo;
        $employee->address = $request->address;
        $employee->Nid = $request->Nid;
        $employee->joiningDate = $request->joiningDate;
        $employee->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    }
}

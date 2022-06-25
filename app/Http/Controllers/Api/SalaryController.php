<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index(){
        $salaries = Salary::select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salaries);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Paid(Request $request, $id)
    {
        $request->validate([
            'salary_month' => 'required',
        ]);

        $check = Salary::where('employee_id', $id)->where('salary_month', $request->salary_month)->first();
        if($check){
            return response()->json('salary Already Paid');
        }

        $salary = new Salary();
        $salary->employee_id = $id;
        $salary->amount = $request->amount;
        $salary->salary_date = date('d/m/y');
        $salary->salary_month = $request->salary_month;
        $salary->salary_year = date('Y');
        $salary->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ViewSalary($id)
    {
        $month = $id;
        $salaries = Salary::with(['employee'])->where('salary_month',$month)->get();
        return response()->json($salaries);
    }

    public function EditSalary($id){
        $salary =Salary::with(['employee'])->findOrFail($id);
        return response()->json($salary);
    }

    public function UpdateSalary(Request $request,$id){
        $salary = Salary::findOrFail($id);
        $salary->salary_month = $request->salary_month;
        $salary->amount = $request->amount;
        $salary->save();
    }

}

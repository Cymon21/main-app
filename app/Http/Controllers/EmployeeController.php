<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Http\Requests\EmployeeStoreRequest;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store(EmployeeStoreRequest $request)
    {
        $data = $request->all();
        $response = employee::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $response,
        ], 200);
    }

    public function fetch(){
        return Employee::all();
    }
    
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $employee,
        ], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully',
        ], 200);
    }
}

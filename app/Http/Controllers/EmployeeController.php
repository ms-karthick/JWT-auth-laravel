<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_data = Employee::all();
        return response()->json([
            "status" => true,
            "message" => "Employee List",
            'data' => $get_data], 200);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            $this->validate($request,[
                'image.*' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $fileNames =  [];
            if($request->hasFile('image')){
                
            foreach($request->file('image') as $image)
            {
                $imageName = $image->getClientOriginalName();              
                $image->move(public_path('/test'), $imageName);
                $fileNames[] = $imageName;
            }
        }
  
        $jsonImg = json_encode($fileNames);
        
            $postData = ['name' => $request->name,
            'image' => $jsonImg, 
            'image_url'=> $request->image_url
        ];
        
            $data = Employee::create($postData); 

                return response()->json([
                    "status" => true,
                    "message" => "Employee Added successfully.",
                    "data" => $data
                    ],200);
     }
      
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, $id)
    {
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, $id)
    {
       
    }
}

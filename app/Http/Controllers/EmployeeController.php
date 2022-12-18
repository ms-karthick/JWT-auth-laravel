<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
        {
            //      $request->validate([
            //     'post_title',
            //     'category_id',
            //     'sub_category_id',
            //     'image' => 'required|image',
            //     'img_url',
            //     'description'
            // ]);
            // $insert = $request->only(['post_title','category_id','sub_category_id','description']);
        
            // $data =  Articles::create($insert);
        
            $request->validate([
                'name',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'img_url',
            ]);
              
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/employee/image', $imageName);
        
            $postData = ['name' => $request->name,'image' => $imageName, 
            'img_url'=> $request->img_url];
        
            $data = Employee::create($postData); 
        
                // $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('articles/image', $request->image,$imageName);
        
            //    $data = Articles::create($request->post()+['image'=>$imageName]);       
        
                return response()->json([
                    "status" => true,
                    "message" => "Employee Added successfully.",
                    "data" => $data
                    ],200);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        {
            // $show = DB::table('articles')->join('categories','categories.id','=', 'articles.category_id')->join('sub_categories','sub_categories.id','=','articles.sub_category_id')->select('categories.title as category_name', 'sub_categories.title as sub_category_name','articles.id','articles.post_title','articles.image','articles.description')->get(find($id));
            $show = Employee:: find($id);
            if (is_null($show)) {
                return $this->sendError('Employee not found.');
                }
                return response()->json([
                "status" => true,
                "message" => "Employee retrieved successfully.",
                "data" => $show
                ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        {
            $select = Employee::find($id);
            if (!$select) {
                return response()->json([
                    'status' => false,
                    'message' => 'this id ' . $id . ' is not found'
                ], 400);
            } 
                return response()->json([
                    'status' => true,
                    'data' => $select], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        {
            $update = Employee::find($id);
          
        $request->validate([
            'post_title',
            'category_id',
            'sub_category_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_url',
            'description'
        ]);
        print_r($request->all());
          try{
            
        $update->fill($request->post())->update();
    
        if($request->hasFile('image')){
    
            if($update->image){
                $exists = Storage::disk('public')->exists("employee/image/{$update->image}");
                if($exists){
                    Storage::disk('public')->delete("employee/image/{$update->image}");
                }
            }
    
            $imageName = Str:: random() . '.'. $request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('employee/image/',$request->image, $imageName);
            $update->image = $imageName;
            $update->save();
        }
    
                return response()->json([
                    'status' => true,
                    "message" => "Employee updated successfully.",
                    'data' => $update
                ], 200);
    
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=> 'something goes wrong'],500);
        }
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        {
            $delete = Employee::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Employee deleted successfully',
                'data' => $delete
            ], 200);
        }
    }
}

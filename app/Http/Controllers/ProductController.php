<?php

namespace App\Http\Controllers;
use App\Product;
use App\User;
use App\ProductApplication;
use App\ProductSubcategories;

use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Current List
    public function current()
    {   
        $products = Product::with(['userById', 'userByUserId'])->where('status', '4')->orderBy('id', 'desc')->get();
        if(request()->ajax())
        {
            return datatables()->of($products)
                    ->addColumn('user_full_name', function (Product $product) {
                        $user = $product->getRelatedUser();
                        return $user ? $user->full_name : '';
                    })
                    ->addColumn('action', function($data){
                        $buttons = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary">Edit</button>';
                        $buttons .= '&nbsp;&nbsp;';
                        $buttons .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger">Delete</button>';
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('products.current'); 
    }

    // New List
    public function new()
    {   
        $products = Product::with(['userById', 'userByUserId'])->where('status', '2')->orderBy('id', 'desc')->get();
        if(request()->ajax())
        {
            return datatables()->of($products)
                    ->addColumn('user_full_name', function (Product $product) {
                        $user = $product->getRelatedUser();
                        return $user ? $user->full_name : '';
                    })
                    ->addColumn('action', function($data){
                        $buttons = '<a type="button" href="' . route("product.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn btn-success">View</a>';
                        $buttons .= '&nbsp;&nbsp;';
                        $buttons .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger">Delete</button>';
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('products.new'); 
    }

    // Draft List 
    public function draft()
    {   
        $products = Product::with(['userById', 'userByUserId'])->where('status', '1')->orderBy('id', 'desc')->get();
        $product_applications = ProductApplication::all();
        $product_subcategories = ProductSubcategories::all();
        // dd($products);
        if(request()->ajax())
        {
            return datatables()->of($products)
                    ->addColumn('user_full_name', function (Product $product) {
                        $user = $product->getRelatedUser();
                        return $user ? $user->full_name : '';
                    })
                    ->addColumn('action', function($data){
                        $buttons = '<a type="button" href="' . route("product.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn btn-success">View</a>';
                        $buttons .= '&nbsp;&nbsp;';
                        $buttons .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary">Edit</button>';
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('products.draft', compact('products','product_applications', 'product_subcategories')); 
    }

    // Archived List
    public function archived()
    {   
        $products = Product::with(['userById', 'userByUserId'])->where('status', '5')->orderBy('id', 'desc')->get();
        if(request()->ajax())
        {
            return datatables()->of($products)
                    ->addColumn('user_full_name', function (Product $product) {
                        $user = $product->getRelatedUser();
                        return $user ? $user->full_name : '';
                    })
                    ->addColumn('action', function($data){
                        $buttons = '<a type="button" href="' . route("product.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn-table btn btn-success"><i class="ti-eye"></i></a>';
                        $buttons .= '&nbsp;&nbsp;';
                        $buttons .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn-table btn btn-danger"><i class="ti-trash"></i></button>';
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('products.archived'); 
    }

    // Store
    public function store(Request $request)
    {
        $rules = array(
            'code'              =>  'required',
            'type'              =>  'required',
            'application_id'    =>  'required'
        );

        $customMessages = [
            'application_id.required'   =>  'The application field is required.',
            'code.required'             =>  'The product code field is required'            
        ];

        $error = Validator::make($request->all(), $rules, $customMessages);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ddw_number'                    =>  $request->ddw_number,
            'code'                          =>  $request->code,
            'reference_no'                  =>  $request->reference_no,
            'type'                          =>  $request->type,
            'application_id'                =>  $request->application_id,
            'application_subcategory_id'    =>  $request->application_subcategory_id,
            'product_origin'                =>  $request->product_origin,
            'created_by'                    =>  auth()->user()->id,
            'status'                        =>  '1'
        );

        Product::create($form_data);

        return response()->json(['success' => 'Data Added Successfully.']);
    }

    // Edit
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        $rules = array(
            'code'              =>  'required',
            'type'              =>  'required',
            'application_id'    =>  'required'
        );

        $customMessages = [
            'application_id.required'   =>  'The application field is required.',
            'code.required'             =>  'The product code field is required'            
        ];

        $error = Validator::make($request->all(), $rules, $customMessages);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ddw_number'                    =>  $request->ddw_number,
            'code'                          =>  $request->code,
            'reference_no'                  =>  $request->reference_no,
            'type'                          =>  $request->type,
            'application_id'                =>  $request->application_id,
            'application_subcategory_id'    =>  $request->application_subcategory_id,
            'product_origin'                =>  $request->product_origin,
        );

        Product::whereId($id)->update($form_data);

        return response()->json(['success' => 'Data is Successfully Updated.']);
    }

    // View
    public function view($id)
    {
        $data = Product::find($id);
        $users = User::all();

        $product_applications = ProductApplication::find($data->application_id);
        $product_subcategories = ProductSubcategories::find($data->application_subcategory_id);
        $userAccounts = $users->firstWhere('user_id', $data->created_by) ?? $users->firstWhere('id', $data->created_by);
        $approveUsers = $users->firstWhere('user_id', $data->approved_by) ?? $users->firstWhere('id', $data->approved_by);
        return view('products.view', compact('data', 'product_applications', 'product_subcategories', 'userAccounts', 'approveUsers'));
    }

    // Delete
    public function delete($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
    }
}

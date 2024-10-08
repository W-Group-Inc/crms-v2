<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Exports\DepartmentExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    // List
    public function index(Request $request)
    {
        // dd();
        $departments = Department::with('company')
            ->when($request->search, function($query)use($request) {
                $query->whereHas('company', function($q)use($request) {
                    $q->where('name', 'LIKE', "%".$request->search."%");
                })
                ->orWhere('department_code', 'LIKE', "%".$request->search."%")
                ->orWhere('name', 'LIKE', "%".$request->search."%")
                ->orWhere('description', 'LIKE', "%".$request->search."%");
            })
            ->latest();

        $companies = Company::where('status', 'Active')->get();
        $search = $request->search;
        $entries = $request->number_of_entries;

        if ($request->fetch_all)
        {
            $departments = $departments->get();
            return response()->json($departments);
        }
        else
        {
            $departments = $departments->paginate($request->number_of_entries ?? 10);

            return view('departments.index', compact('departments', 'companies', 'search', 'entries'));
        }
    }
    
    // Store
    public function store(Request $request) 
    {
        $rules = array(
            'code' => 'unique:departments,department_code'
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all(), 'status' => 0]);
        }
        else
        {
            $department = new Department;
            $department->company_id = $request->company_id;
            $department->department_code = $request->code;
            $department->name = $request->name;
            $department->description = $request->description;
            $department->status = "Active";
            $department->save();

            return response()->json(['message' => 'Successfully Saved', 'status' => 1]);
        }
    }

    // Edit
    public function edit($id)
    {
        $data = Department::findOrFail($id);

        return response()->json(['data' => $data]);
    }

    // Update
    public function update(Request $request, $id)
    {
        $rules = array(
            'code' => 'unique:departments,department_code,' . $id
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all(), 'status' => 0]);
        }
        else
        {
            $department = Department::findOrFail($id);
            $department->company_id = $request->company_id;
            $department->department_code = $request->code;
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();

            return response()->json(['message' => 'Successfully Update', 'status' => 1]);
        }
    }

    // Delete
    public function active($id)
    {
        $department = Department::findOrFail($id);
        $department->status = 'Active';
        $department->save();

        Alert::success('Successfully Activated')->persistent('Dismiss');
        return back();
    }

    public function deactive($id)
    {
        $department = Department::findOrFail($id);
        $department->status = 'Inactive';
        $department->save();

        Alert::success('Successfully Deactivated')->persistent('Dismiss');
        return back();
    }

    public function exportDepartment()
    {
        return Excel::download(new DepartmentExport, 'Department.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditEmployee;
use App\Http\Requests\ImportEmployee;
use App\Http\Requests\StoreEmployee;
use App\Imports\EmployeesImport;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('employees-list');
    }
    public function add()
    {
        return view('employees-form');
    }

    public function getEmployees(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Employees::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Employees::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Employees::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $index => $record) {
            $id = $record->id;
            $no = $index + 1;
            $name = $record->name;
            $email = $record->email;
            $company = $record->company->name;

            $data_arr[] = array(
                "id" => $id,
                "no" => $no,
                "name" => $name,
                "email" => $email,
                "company" => $company,
                "action" => '<a type="button" href="/employees/edit/' . $id . '" class="btn btn-warning">Edit</a><a type="button" href="/employees/delete/' . $id . '" class="btn btn-danger ml-2">Delete</a>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function store(StoreEmployee $request)
    {
        Employees::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
        ]);
        return redirect()->route('employees');
    }

    public function show(Employees $employee)
    {
        $data['employee'] = $employee;
        return view('employees-form-edit')->with($data);
    }

    public function edit(EditEmployee $request, Employees $employee)
    {
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
        ]);
        return redirect()->route('employees');
    }

    public function delete(Employees $employee)
    {
        $employee->delete();
        return redirect()->back()->withSuccess('Success Delete ' . $employee->name);
    }

    public function import(ImportEmployee $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('excel');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('file_excel', $nama_file);
            $array = (new EmployeesImport)->toArray(public_path('/file_excel/' . $nama_file));
            // if (count($array) >= 100) {
            Excel::import(new EmployeesImport, public_path('/file_excel/' . $nama_file));
            // } else {
            //     return  redirect()->back()->withErrors('Rows are under 100');
            // }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Import Companies');
    }
}

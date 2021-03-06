<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditCompany;
use App\Http\Requests\ImportCompany;
use App\Http\Requests\StoreCompany;
use App\Imports\CompaniesImport;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('companies-list');
    }
    public function add()
    {
        return view('companies-form');
    }

    public function getCompanies(Request $request)
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
        $totalRecords = Companies::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Companies::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Companies::orderBy($columnName, $columnSortOrder)
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
            $website = $record->website;

            $data_arr[] = array(
                "id" => $id,
                "no" => $no,
                "name" => $name,
                "email" => $email,
                "website" => $website,
                "action" => '<a type="button" href="/companies/edit/' . $id . '" class="btn btn-warning">Edit</a><a type="button" href="/companies/delete/' . $id . '" class="btn btn-danger ml-2">Delete</a><a type="button" href="/companies/export/' . $id . '" class="btn btn-success ml-2">Export Employee</a>',
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

    public function store(StoreCompany $request)
    {
        DB::beginTransaction();
        try {
            $logo = Storage::putFile('public/company', $request->file('logo'));
            Companies::insert([
                'name' => $request->name,
                'email' => $request->email,
                'logo' => $logo,
                'website' => $request->website,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->route('companies');
    }

    public function show(Companies $company)
    {
        $data['company'] = $company;
        $data['company']['path'] = Storage::url(str_replace('public/', '', $company->logo));
        return view('companies-form-edit')->with($data);
    }

    public function edit(EditCompany $request, Companies $company)
    {
        DB::beginTransaction();
        try {
            if (isset($request->logo)) {
                $logo = Storage::putFile('public/company', $request->file('logo'));
                $company->update(['logo' => $logo]);
            }
            $company->update([
                'name' => $request->name,
                'email' => $request->email,
                'website' => $request->website,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->route('companies');
    }

    public function delete(Companies $company)
    {
        $company->delete();
        return redirect()->back()->withSuccess("Success Delete Company " . $company->name);
    }

    function search_company($search)
    {
        $search = str_replace('%20', ' ', $search);
        $data = Companies::where('name', 'like', '%' . $search . '%')->get();
        $dat = array();
        foreach ($data as $index => $value) {
            $dat[$index] = array();
            $dat[$index]['id'] = $value["id"];
            $dat[$index]['text'] = $value["name"];
            //echo json_encode($dat[$index]);
        }
        $array = array(
            'results' => $dat,
            'pagination' => array('more' => true)
        );
        echo json_encode($array);
    }

    public function export(Companies $company)
    {
        $pdf = PDF::loadview('pdf.companies-export', ['company' => $company])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('companies.pdf');
    }

    public function import(ImportCompany $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('excel');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('file_excel', $nama_file);
            $array = (new CompaniesImport)->toArray(public_path('/file_excel/' . $nama_file));
            if (count($array) >= 100) {
                Excel::import(new CompaniesImport, public_path('/file_excel/' . $nama_file));
            } else {
                return  redirect()->back()->withErrors('Rows are under 100');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Import Companies');
    }
}

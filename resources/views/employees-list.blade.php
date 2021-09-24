@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
    @endif
    @if (session('errors'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session('errors') }}</li>
        </ul>
    </div>
    @endif
    <a type="button" href="/employees/add" class="btn btn-primary mb-3">Add Employee</a>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalImport">
        Import Excel
    </button>
    <table id='empTable' class="table" width='100%' border="1" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <td>No</td>
                <td>Name</td>
                <td>Email</td>
                <td>Company</td>
                <td>Action</td>
            </tr>
        </thead>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('employees.import')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="excel" />
                    </div>
                    <div class="modal-footer">
                        <a type="button" href="/file_excel/contoh-employee.xlsx" class="btn btn-success">Contoh Excel</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-script')
<!-- Script -->
<script type="text/javascript">
    $(document).ready(function() {
        // DataTable
        var t = $('#empTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('employees.getEmployees')}}",
            pageLength: 5,
            columnDefs: [{
                "targets": [0, 4],
                "searchable": false,
                "orderable": false,
            }],
            order: [
                [1, 'asc']
            ],
            columns: [{
                    data: 'no'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'company'
                },
                {
                    data: 'action'
                },
            ]
        });

    });
</script>
@endpush
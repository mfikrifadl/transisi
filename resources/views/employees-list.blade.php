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
    <a type="button" href="/employees/add" class="btn btn-primary mb-3">Add Employee</a>
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
@extends('layouts.app')

@section('content')
<div class="container">
    <a type="button" href="/companies/add" class="btn btn-primary mb-3">Add Company</a>
    <table id='compTable' class="table" width='100%' border="1" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <td>No</td>
                <td>Name</td>
                <td>Email</td>
                <td>Website</td>
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
        var t = $('#compTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('companies.getCompanies')}}",
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
                    data: 'website'
                },
                {
                    data: 'action'
                },
            ]
        });

    });
</script>
@endpush
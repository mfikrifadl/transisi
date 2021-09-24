@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h3>Edit Employee</h3>
    <form method="post" action="{{route('employees.edit', $employee)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" value="{{ old('name') ? old('name') : $employee->name}}" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') ? old('email') : $employee->email}}" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label class="form-label">Company</label>
            <select class="selectComp form-control" name="company_id">
                <option selected value="{{$employee->company_id}}">{{$employee->company->name}}</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" href="/companies" class="btn btn-warning">Back</a>
    </form>
</div>
@endsection

@push('custom-script')
<!-- Script -->
<script type="text/javascript">
    let _token = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('.selectComp').select2({
            minimumInputLength: 3,
            allowClear: true,
            placeholder: 'Input Company',
            ajax: {
                type: 'POST',
                url: function(params) {
                    return "/companies/search_company/" + params.term;
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',

                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }
        });
    });
</script>
@endpush
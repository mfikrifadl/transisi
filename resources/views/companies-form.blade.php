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
    <h3>Add Company</h3>
    <form method="post" action="{{route('companies.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" value="{{ old('name') }}" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" max-file-size="1953" id="logo" onchange="checkFileSize()" value="{{ old('logo') }}" accept=".png" name="logo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="text" class="form-control" name="website" value="{{ old('website') }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" href="/companies" class="btn btn-warning">Back</a>
    </form>
</div>
@endsection

@push('custom-script')
<!-- Script -->
<script type="text/javascript">
    function checkFileSize() {
        if ($('#logo').prop('files')[0].size > 2000000) {
            alert("File is too big!");
            $('#logo').val('')
        };
    }
</script>
@endpush
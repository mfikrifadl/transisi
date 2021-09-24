@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Soal 5</h3>
    <form method="post" action="{{route('soal.5')}}" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">String</label>
            <input type="text" class="form-control" value="{{ old('string') }}" placeholder="ex DFHKNQ" name="string">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if (\Session::has('message'))
    <h5>{{session('message')}}</h5>
    @endif
</div>
@endsection
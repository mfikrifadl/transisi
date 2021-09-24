@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Soal 1</h3>
    <form method="post" action="{{route('soal.1')}}" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="text" class="form-control" value="{{ old('nilai') }}" placeholder="ex 72 65 73 78 75 74 90 81 87 65 55 69 72 78 79 91 100 40 67 77 86" name="nilai">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if (\Session::has('average'))
    <h5>Last Input : {{session('input')}}</h5>
    <h5>Nilai Rata rata : {{session('average')}}</h5>
    <h5>Nilai Terendah : {{session('terendah')}}</h5>
    <h5>Nilai Tertinggi : {{session('tertinggi')}}</h5>
    @endif
</div>
@endsection
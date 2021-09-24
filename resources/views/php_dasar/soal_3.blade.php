@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Soal 3</h3>
    <form method="post" action="{{route('soal.3')}}" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">String</label>
            <input type="text" class="form-control" value="{{ old('string') }}" placeholder="ex Jakarta adalah ibukota negara Republik Indonesia" name="string">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if (\Session::has('unigram'))
    <h5>Last Input : {{session('input')}}</h5>
    <h5>Unigram : {{session('unigram')}}</h5>
    <h5>Bigram : {{session('bigram')}}</h5>
    <h5>Trigram : {{session('trigram')}}</h5>
    @endif
</div>
@endsection
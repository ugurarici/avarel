@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-columns">
        @include('helpers.articlecards', ['articles' => $articles])   
    </div>
</div>
@endsection
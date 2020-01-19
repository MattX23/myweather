@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <home
            :location="{{ $user->preferredLocation->location }}"
            :messages="{{ $messages }}">
        </home>
    </div>
</div>
@endsection

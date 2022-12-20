@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.validation')
            {{ Form::open(['url' => route('gift.update')]) }}
            {{ Form::hidden('id', $gift->id) }}
            <div class="card">
                <div class="card-header">{{ __('欲しいモノ登録') }}</div>

                <div class="card-body">
                    @include('gift.components.form')
                    {{ Form::submit('変更',['class' => 'btn btn-primary mt-2 form-control']) }}
                    <a href="{{ route('gift.destroy', ['id' => $gift->id])}}" class="btn btn-danger mt-2 form-control"> 削除 </a>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

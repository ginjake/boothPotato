@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.validation')
            {{ Form::open(['url' => route('gift.store')]) }}
            <div class="card">
                <div class="card-header">{{ __('欲しいモノ登録') }}</div>

                <div class="card-body">
                    @include('gift.components.form')
                    {{ Form::submit('登録',['class' => 'btn btn-primary mt-2 form-control']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

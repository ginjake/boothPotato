@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex flex-wrap mt-5">
                @empty($user)
                    <div class="alert alert-danger col-md-12" role="alert">
                        ユーザーページのURLルールが変更されました。お手数ですが、リンクの張り直しをお願いします
                    </div>
                @endempty
                @isset($user->gifts)
                    @foreach($user->gifts as $gift)
                        @empty($gift->giftCache)
                            @continue
                        @endempty
                        <div class="card w-25 mb-5">
                            <a href="{{ $gift->url}}" class="text-decoration-none text-reset">
                                <div class="card-body">
                                    <div>
                                        <div>
                                            <img src="{{ $gift->giftCache->image}}" width="100%">
                                        </div>
                                        <div>
                                            <div class="small">
                                                {{ htmlspecialchars_decode($gift->giftCache->title)}}
                                            </div>
                                            <!--
                                            <div class="small mt-1">
                                                <div>{{ $gift->giftCache->description}}</div>
                                            </div>
                                            -->
                                            @isset($gift->memo)
                                            <div class="mt-3">
                                                <div>【メモ】</div>
                                                <div>{{ $gift->memo }}</div>
                                            </div>
                                            @endisset
                                            <div class="mt-3">
                                                <div>【優先度】</div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div>{{ GiftConstants::PRIORITY[$gift->priority] }}</div>
                                                    </div>
                                                    <div class="col-6">
                                                        @can('update-gift', $gift)
                                                            <div>
                                                                <a href="{{ route('gift.edit', [$gift])}}" class="btn btn-primary">編集</a>
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
@endsection

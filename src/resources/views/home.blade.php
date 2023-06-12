@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex flex-wrap mt-2">
                @empty($user)
                    <div class="alert alert-danger col-md-12" role="alert">
                        ユーザーページのURLルールが変更されました。お手数ですが、リンクの張り直しをお願いします
                    </div>
                @endempty
                @if($user->twitterId == config('value.ginjakeTwitterId'))
                <div class="alert alert-info col-md-12" role="alert">
                    サーバー代の補填として、何か奢ってもらえると泣いて喜びます<br>
                    管理人ginjakeのtwitterは<a href="https://twitter.com/sirojake" target="_blank">こちら</a>
                </div>
                @endif
                @foreach($gifts as $gift)
                    @empty($gift->giftCache)
                        @continue
                    @endempty
                    <div class="card col-md-3  col-sd-6 mb-2">
                        <a href="{{ $gift->giftCache->boothUrl}}" target="_blank" class="text-decoration-none text-reset">
                            <div class="card-body">
                                <div>
                                    <div>
                                        <div class="position-relative">
                                            <img class="card-image" src="{{ $gift->giftCache->image}}" width="100%">
                                            <span class="text-white px-2 bg-warning position-absolute bottom-0 end-0">￥{{ $gift->giftCache->price }}</span>
                                        </div>
                                        <div class="">
                                            <div class="mt-1 position-absolute top-0">
                                                <span class="text-white  mt-2 px-2 bg-info">{{ $gift->giftCache->category->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small">
                                            {{ htmlspecialchars_decode($gift->giftCache->title)}}
                                            <div class="badge bg-primary">
                                                <div>{{ GiftConstants::PRIORITY[$gift->priority] }}</div>
                                            </div>
                                        </div>

                                        @isset($gift->memo)
                                        <div class="mt-3">
                                            <div class="badge bg-secondary">メモ</div>
                                            <div class="text-muted">{{ $gift->memo }}</div>
                                        </div>
                                        @endisset
                                        <div class="mt-1">
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
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

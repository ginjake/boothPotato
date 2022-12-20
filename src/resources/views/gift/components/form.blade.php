<div>
    {{ __('商品URL') }}
    {{ Form::text('url', $gift->url ?? null, ['class' => 'form-control', 'placeholder' => 'boothの商品URL','required' ]) }}
</div>
<div class="mt-2">
    {{ __('メモ') }}
    {{ Form::text('memo', $gift->memo ?? null, ['class' => 'form-control', 'placeholder' => '衣装がアバター毎に分かれている場合などはここに記入' ]) }}
</div>
<div class="mt-2">
    {{ __('欲しさ') }}
    {{ Form::select('priority', GiftConstants::PRIORITY, $gift->priority ?? null, ['class' => 'form-select'])}}
</div>

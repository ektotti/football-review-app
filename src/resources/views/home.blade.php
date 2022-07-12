@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <post-card
            :is-index='@json($isIndex)'
            :tag-name='@json($tagName)'
        >
        </post-card>
        <div class="col-md-4 text-center">
            <div class="mb-4">
                <fixture-card
                    :list-title="'最近の試合'"
                > 
                </fixture-card>
            </div>
            <div class="">
                <fixture-card
                    :list-title="'もうすぐキックオフ！'"
                    :is-coming-soon="@json(true)"
                >
                </fixture-card>
            </div>
        </div>
    </div>
</div>
@endsection
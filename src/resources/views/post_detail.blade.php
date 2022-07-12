@extends('layouts.app')

@section('content')
<div class="container row">
    <post-card :init-post='@json($post)' :errors=@json($errors->all()) :is-index="false" :like-this-post="@json($likeThisPost)" :is-self='@json($isSelf)'>
    </post-card>
    <portal-target name="modal"></portal-target>
</div>
@endsection
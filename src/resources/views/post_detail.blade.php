@extends('layouts.app')

@section('content')
<div class="container row">
    <post-card :init-post='@json($post)' :errors=@json($errors->all()) :is-index="false">
    </post-card>
    <portal-target name="modal"></portal-target>
</div>
@endsection
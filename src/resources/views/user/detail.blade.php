@extends('layouts.app')

@section('content')
<div class="container">
    <Profiel :selected-user='@json($selectedUser)' :login-user='@json($loginUser)' :is-following='@json($isFollowing)' :is-self='@json($isSelf)'>
    </Profiel>
    <post-card :is-index='@json($isIndex)'>
    </post-card>
</div>
<portal-target name="modal"></portal-target>
@endsection
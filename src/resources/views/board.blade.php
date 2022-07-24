@extends('layouts.board')

@section('content')
<tactical-board :is-post="false" :selected-match='@json($selectedMatch)'></tactical-board>
<portal-target name="modal"></portal-target>
@endsection
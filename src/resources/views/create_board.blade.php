@extends('layouts.board')

@section('content')
<tactical-board 
:is-post='@json($isPost)'
></tactical-board>
<portal-target name="modal"></portal-target>
@endsection
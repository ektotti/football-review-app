@extends('layouts.app')

@section('content')
<tactical-board 
:is-post="true"
></tactical-board>
<portal-target name="modal"></portal-target>
@endsection
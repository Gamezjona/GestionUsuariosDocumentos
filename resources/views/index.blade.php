@extends('layouts.app')
 
@section('titulo', 'Inicio')
 
@section('cabecera')
    {{-- @parent Este muestra lo que tiene el padre --}}
 
    <p>Esto se pasa a la pagina maestra</p>
@endsection
 
@section('contenido')
    <p>This is my body content.</p>
@endsection
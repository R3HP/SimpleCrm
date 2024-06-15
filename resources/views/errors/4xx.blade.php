@extends('errors::minimal') 
@section('title','General Error Page')

{{ $exception->getMessage() }}
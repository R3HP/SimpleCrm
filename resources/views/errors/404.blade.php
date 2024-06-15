@extends('errors::minimal')

@section('title', __('یافت می نشود'))
@section('code', '404')
@section('message', __('صفحه مورد نظر یافت می نشد'))
{{ $exception->getMessage() }}
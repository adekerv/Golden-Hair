@extends('layouts.app')

@section('title', $business['name'].' — Coiffure • Barber au Lamentin')

@section('content')
    @include('sections.hero')
    @include('sections.hairstyles')
    @include('sections.products')
    @include('sections.gallery')
    @include('sections.contact')
@endsection

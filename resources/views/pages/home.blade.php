@extends('layouts.app')

@section('title', $business['name'].' — Coiffure • Barber au Lamentin')

@push('head')
    <script type="application/ld+json">{!! $structuredData !!}</script>
@endpush

@section('content')
    @include('sections.hero')
    @include('sections.hairstyles')
    @include('sections.products')
    @include('sections.gallery')
    @include('sections.contact')
@endsection

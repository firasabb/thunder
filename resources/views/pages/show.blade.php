@extends('layouts.app')

    @push('head_scripts')
        @if($page->seo_keywords)
            <meta name="keywords" content="{{ $page->seo_keywords }}">
        @endif

        @if($page->seo_description)
            <meta name="description" content="{{ $page->seo_description }}">
        @endif
    @endpush


    @section('content')


        <div class="row justify-content-center py-5">          
            
            <div class="col-lg-6 col-md-8 col-sm-10">

                <div class="row mt-3">
                    <div class="col">
                        @if($page->featured_full_url)
                            <div class="mb-3">
                                <img class="w-100" src="{{ $page->featured_full_url }}" alt="{{ $page->title }}">
                            </div>
                        @endif
                        <article>{!! $page->body !!}</article>
                    </div>
                </div>
            </div>

        </div>

    @endsection

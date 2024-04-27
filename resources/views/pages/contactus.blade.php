@extends('layouts.app')

    @push('head_scripts')
            <meta name="keywords" content="Quetab, contact">

            <meta name="description" content="Contact Quetab Customer Support">
    @endpush


    @section('content')


        <div class="row justify-content-center py-5">          
            
            <div class="col-lg-6 col-md-8 col-sm-10">
                
                <div class="row">
                    <div class="col">
                        <h1>Contact Us</h1>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <span>Please submit your inquiry with the right information using the form below:</span>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <x-forms.contact></x-forms.contact>
                    </div>
                </div>
            </div>

        </div>

        <x-messages.floating-message/>

    @endsection

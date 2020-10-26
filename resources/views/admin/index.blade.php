@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="banner text-center">
                <img src="{{asset('assets/images/home_page_logo.png')}}" alt="Logo" class="img-responsive">
            </div>

            <div class="pages">
                <div class="item">
                    <img src="{{asset('assets/images/circle.png')}}" alt="Users">
                    <a href="/users" class="waves-effect text-bold text-uppercase">
                        <span class="hide-menu">Users</span></a>
                </div>
                <div class="item">
                    <img src="{{asset('assets/images/circle.png')}}" alt="Users">
                    <a href="/activities" class="waves-effect text-bold text-uppercase">
                        <span class="hide-menu">Activities</span></a>
                </div>
                <div class="item">
                    <img src="{{asset('assets/images/circle.png')}}" alt="Food Items">
                    <a href="/foods" class="waves-effect text-bold text-uppercase">
                        <span class="hide-menu">Food Items</span></a>
                </div>
                <div class="item">
                    <img src="{{asset('assets/images/circle.png')}}" alt="Meals">
                    <a href="/meals" class="waves-effect text-bold text-uppercase">
                        <span class="hide-menu">Meals</span></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('header')
    <style>
        .item a {
            color: black;
            font-size: 20px;
            padding-top: 10px;
        }

        #page-wrapper {
            background: white !important;
        }

        .page-title {
            display: none;
        }

        .banner, .pages {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .pages {
            padding-top: 80px;
        }

        .item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            padding-top: 15px;
        }


    </style>
@endpush

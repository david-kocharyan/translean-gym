@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="banner text-center">
                <img src="{{asset('assets/images/home_page_logo.png')}}" alt="Logo" class="img-responsive">
            </div>

            <div class="pages">
                <div class="item">
                    <a href="/users" class="waves-effect text-bold text-uppercase">
                        <div class="circle-div">
                            <i class="mdi mdi-account"></i>
                        </div>
                        <span class="hide-menu">Users</span>
                    </a>
                </div>
                <div class="item">
                    <a href="/activities" class="waves-effect text-bold text-uppercase">
                        <div class="circle-div">
                            <i class="mdi mdi-pulse"></i>
                        </div>
                        <span class="hide-menu">Activities</span>
                    </a>
                </div>
                <div class="item">
                    <a href="/foods" class="waves-effect text-bold text-uppercase">
                        <div class="circle-div">
                            <i class="mdi mdi-carrot"></i>
                        </div>
                        <span class="hide-menu">Food Items</span>
                    </a>
                </div>
                <div class="item">
                    <a href="/meals" class="waves-effect text-bold text-uppercase">
                        <div class="circle-div">
                            <i class="mdi mdi-silverware-variant"></i>
                        </div>
                        <span class="hide-menu">Meals</span>
                    </a>
                </div>

                <div class="item">
                    <div class="dropdown show">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="circle-div">
                                <i class="mdi mdi-settings"></i>
                            </div>
                            <span class="hide-menu">Settings</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a href="/met-range" class="waves-effect">
                                <i class="mdi mdi-run-fast fa-fw"></i>
                                <span class="hide-menu">MET Ranges</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('header')
    <style>
        .item a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            color: black;
            font-size: 20px;
            padding-top: 10px;
        }

        .item a:hover {
            color: green;
        }

        .item a span {
            padding-top: 20px;
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

        .banner img{
            height: 213px;
        }

        .pages {
            padding-top: 80px;
        }

        .circle-div{
            height: 100px;
            width: 100px;
            background: #e3e3e3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-div i{
            font-size: 50px;
        }

    </style>
@endpush

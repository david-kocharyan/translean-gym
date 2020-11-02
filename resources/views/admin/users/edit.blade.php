@extends('layouts.app')

@section('content')
    @include('admin.users.tab')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">{{$action." ".$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$user->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Name" name="name" value="{{$user->name}}">
                            </div>

                            <div class="form-group">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                @error('username')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="username"
                                       placeholder="Username" name="username" value="{{$user->username}}">
                            </div>

                            <div class="form-group">
                                <label for="password">Password </label>
                                @error('password')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="password"
                                       placeholder="Password" name="password">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                @error('email')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="email" class="form-control" id="email"
                                       placeholder="Email" name="email" value="{{$user->email}}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                @error('phone')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="phone"
                                       placeholder="Phone Number" name="phone" value="{{$user->phone}}">
                            </div>

                            <div class="form-group">
                                <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                @error('dob')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="date" class="form-control" id="dob"
                                       placeholder="Date of Birth" name="dob" value="{{$user->dob}}">
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                @error('gender')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="gender" id="gender" class="form-control">
                                    @foreach(\App\Model\User::GENDER as $key=>$val)
                                        <option value="{{$key}}" @if($user->gender === $key) selected @endif>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="height">Height (sm) <span class="text-danger">*</span></label>
                                @error('height')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="height"
                                       placeholder="Height" name="height" value="{{$user->height}}">
                            </div>

                            <div class="form-group">
                                <label for="dimmer">Dimmer <span class="text-danger">*</span></label>
                                @error('dimmer')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="dimmer" step="any"
                                       placeholder="Dimmer" name="dimmer" value="{{$user->dimmer}}">
                            </div>

                            <div class="form-group">
                                <label for="protein_hourly_limit">Protein Hourly Limit <span class="text-danger">*</span></label>
                                @error('protein_hourly_limit')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="protein_hourly_limit" step="any"
                                       placeholder="Protein Hourly Limit" name="protein_hourly_limit" value="{{$user->protein_hourly_limit}}">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                @error('image')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="image" name="image" class="dropify" data-default-file="{{asset("uploads/$user->image")}}"/>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
                                Save {{$title}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer')
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush

@push('header')
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
@endpush

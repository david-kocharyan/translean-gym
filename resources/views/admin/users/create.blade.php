@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">{{$action." User"}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Name" name="name" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                @error('username')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="username"
                                       placeholder="Username" name="username" value="{{old('username')}}">
                            </div>

                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
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
                                       placeholder="Email" name="email" value="{{old('email')}}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                @error('phone')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="phone"
                                       placeholder="Phone Number" name="phone" value="{{old('phone')}}">
                            </div>

                            <div class="form-group">
                                <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                @error('dob')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="date" class="form-control" id="dob"
                                       placeholder="Date of Birth" name="dob" value="{{old('dob')}}">
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                @error('gender')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="gender" id="gender" class="form-control">
                                    @foreach(\App\Model\User::GENDER as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="height">Height (sm) <span class="text-danger">*</span></label>
                                @error('height')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="height"
                                       placeholder="Height" name="height" value="{{old('height')}}">
                            </div>

                            <div class="form-group">
                                <label for="dimmer">Dimmer <span class="text-danger">*</span></label>
                                @error('dimmer')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="dimmer" step="any"
                                       placeholder="Dimmer" name="dimmer" value="{{old('dimmer')}}">
                            </div>

                            <div class="form-group">
                                <label for="protein_hourly_limit">Protein Hourly Limit <span
                                        class="text-danger">*</span></label>
                                @error('protein_hourly_limit')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="number" class="form-control" id="protein_hourly_limit" step="any"
                                       placeholder="Protein Hourly Limit" name="protein_hourly_limit"
                                       value="{{old('protein_hourly_limit')}}">
                            </div>

                            <div class="form-group">
                                <label for="wake_up_time">Wake Up Time</label>
                                @error('wake_up_time')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="wake_up_time" id="wake_up_time" class="form-control">
                                    <option value="">Choose</option>
                                    @for($i = 1; $i <= 24; $i++)
                                        @if($i == 24)
                                            <option value="{{'00:00'}}"  @if(old('wake_up_time') == '00:00') selected @endif>{{'00:00'}}</option>
                                        @elseif($i < 10)
                                            <option value="{{'0'.$i.':00'}}" @if(old('wake_up_time') == '0'.$i.':00') selected @endif>{{'0'.$i.':00'}}</option>
                                        @else
                                            <option value="{{$i.':00'}}" @if(old('wake_up_time') == $i.':00') selected @endif>{{$i.':00'}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="wake_up_time">Sleep Time</label>
                                @error('sleep_time')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <select name="sleep_time" id="sleep_time" class="form-control">
                                    <option value="">Choose</option>
                                    @for($i = 1; $i <= 24; $i++)
                                        @if($i == 24)
                                            <option value="{{'00:00'}}"  @if(old('sleep_time') == '00:00') selected @endif>{{'00:00'}}</option>
                                        @elseif($i < 10)
                                            <option value="{{'0'.$i.':00'}}" @if(old('sleep_time') == '0'.$i.':00') selected @endif>{{'0'.$i.':00'}}</option>
                                        @else
                                            <option value="{{$i.':00'}}" @if(old('sleep_time') == $i.':00') selected @endif>{{$i.':00'}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                @error('image')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="image" name="image" class="dropify"/>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
                                Save User
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

@extends('admin_layout.app')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3 class="fw-bold">Availability</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Availability
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 text-end">
            @can('admin-hours-breaks')
            <a href="{{ route('hours-breaks') }}" class="btn btn-primary btn-sm">Hours Breaks</a>
            @endcan
            @can('admin-days-breaks')
            <a href="{{ route('days-breaks') }}" class="btn btn-primary btn-sm">Days Breaks</a>
            @endcan
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Day</th>
                    <th scope="col">Punch In</th>
                    <th scope="col">Punch Out</th>
                    <th scope="col">Break In</th>
                    <th scope="col">Break Out</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($availabilities as $availability)
                <form action="{{route('store-availability')}}" method="post">
                    @csrf
                    <tr>
                    <td>{{$availability->day}}
                        <input type="hidden" name="day" value="{{$availability->day}}">
                    </td>
                    <td><input type="time" name="punch_in" value="{{ convertToUserTimezone($availability->punch_in, auth()->user()->timezone) }}"></td>
                    <td><input type="time" name="punch_out" value="{{ convertToUserTimezone($availability->punch_out, auth()->user()->timezone) }}"></td>
                    <td><input type="time" name="break_in" value="{{ convertToUserTimezone($availability->break_in, auth()->user()->timezone) }}"></td>
                    <td><input type="time" name="break_out" value="{{ convertToUserTimezone($availability->break_out, auth()->user()->timezone) }}"></td>
                    <td><button class="btn btn-success btn-sm" type="submit">Update</button></td>
                </tr>
                </form>
                @endforeach
            </tbody>
        </table>
    @endsection
    @section('js')
    @endsection

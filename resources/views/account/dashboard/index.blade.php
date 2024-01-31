@extends('account.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm text-white active">Dashboard</li>
    @endsection

    <style>
    .clockdate-wrapper {
        width:100%;
        text-align:center;
        border-radius:5px;
        margin:0 auto;
    
    }
    #clock{
        font-size:2rem;
        font-weight: 600;
        text-shadow:0px 0px 1px #fff;
        color:#333;
    }
    #date {
        letter-spacing:3px;
        font-size:14px;
        font-weight: 500;
        color:#67748e;
        text-shadow:0px 0px 1px #fff;
    }
    </style>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="greetings fs-3 text-dark fw-600 fw-bold mb-0"></p>
                        <p class="mb-0">Welcome to the Dashboard! Stay positive and keep going!</p>
                    </div>
                    <div id="clockdate" class="d-none d-md-block">
                        <div class="clockdate-wrapper">
                            <div id="clock"></div>
                            <span id="date"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="table-responsive table-hover rounded-3" style="background: #f8fafb;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;">
                            <h5 class="ms-3 mt-3">Latest applied applications</h5>
                            <table class="table">
                                <thead>
                                    <th class="ps-3">Price name</th>
                                    <th>Type</th>
                                    <th class="ps-3">Status</th>
                                    <th class="text-center">Applied At</th>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $application)
                                        <tr>
                                            <td>
                                                <span class="text-sm ms-2">
                                                    @if ($application->type == '1')
                                                        {{ $application->applicationSetting->price1_name }}
                                                    @else
                                                        {{ $application->applicationSetting->price2_name }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-sm">{{ ucfirst($application->applicationSetting->type) }}</td>
                                            <td>
                                                @if ($application->status == 'pending')
                                                    <span class="badge badge-sm badge-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-sm badge-success">Completed</span>
                                                @endif
                                            </td>
                                            <td class="text-sm text-center">
                                                {{ $application->created_at->format('d M, Y g:i A') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No application available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let date = new Date();
            let hours = date.getHours();
            let greeting;

            if (hours < 12) {
                greeting = 'Good Morning';
            } else if (hours < 18) {
                greeting = 'Good Afternoon';
            } else {
                greeting = 'Good Evening';
            }
            document.querySelector('.greetings').textContent = `${greeting}, {{ auth()->user()->full_name }}!`;
            startTime();
        });
        function startTime() {
            let today = new Date();
            let hr = today.getHours();
            let min = today.getMinutes();
            let sec = today.getSeconds();
            ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
            hr = (hr == 0) ? 12 : hr;
            hr = (hr > 12) ? hr - 12 : hr;
            hr = checkTime(hr);
            min = checkTime(min);
            sec = checkTime(sec);
            document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
            
            let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            let days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            let curWeekDay = days[today.getDay()];
            let curDay = today.getDate();
            let curMonth = months[today.getMonth()];
            let curYear = today.getFullYear();
            let date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear;
            document.getElementById("date").innerHTML = date;
            
            let time = setTimeout(function(){ startTime() }, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    </script>
@endpush
<?php
function getUserTimezone($timezone = null)
{
    if ($timezone) {
        return $timezone;
    }

    if (auth()->check() && auth()->user()->timezone) {
        return auth()->user()->timezone;
    }

    if (session()->has('browser_timezone')) {
        return session('browser_timezone');
    }

    return config('app.timezone'); // final fallback
}

// 24 hours format
function convertToUserTimezone($time, $timezone = null)
{
    $format = 'H:i';
    $userTimezone = getUserTimezone($timezone);
    
    if($time){
    // If user's timezone is UTC (same as DB), no need to convert
    if ($userTimezone === 'UTC') {
        return \Carbon\Carbon::parse($time)->format($format);
    }

    // Otherwise convert to user's timezone
    return \Carbon\Carbon::parse($time)
        ->timezone($userTimezone)
        ->format($format);
}else{
    return '';
}
}

function convertToUserTime($time, $timezone = null)
{
    $format = 'h:i A';
    $userTimezone = getUserTimezone($timezone);

    if($time){
    // If user's timezone is UTC (same as DB), no need to convert
    if ($userTimezone === 'UTC') {
        return \Carbon\Carbon::parse($time)->format($format);
    }

    // Otherwise convert to user's timezone
    return \Carbon\Carbon::parse($time)
        ->timezone($userTimezone)
        ->format($format);
}else{
    return '';
}
}

function convertToUserDateTime($datetime, $timezone = null)
{
    $format = 'M d, Y | h:i A';
    $userTimezone = getUserTimezone($timezone);

    if($datetime){
    // If user's timezone is UTC (same as DB), no need to convert
    if ($userTimezone === 'UTC') {
        return \Carbon\Carbon::parse($datetime)->format($format);
    }

    // Otherwise convert to user's timezone
    return \Carbon\Carbon::parse($datetime)
        ->timezone($userTimezone)
        ->format($format);
}else{
    return '';
}
}

function changeDateFormat($date){
    $format = 'M d, Y';
    if($date){
        return \Carbon\Carbon::parse($date)->format($format);
    }else{
        return '';
    }
}

?>
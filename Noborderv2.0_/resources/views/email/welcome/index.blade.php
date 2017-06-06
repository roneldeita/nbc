Welcome to No Border Club {{$user->email}}!
<br>
Thank you for signing up for No Border Club!<br>
Please verify Your Email Address by clicking the link below.<br><br>


<a href="{{url('/validate_email/'.$user->verification.'/'.$user->email)}}">
    {{url('/validate_email/'.$user->verification.'/'.$user->email)}}
</a>

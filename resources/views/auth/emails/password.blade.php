<p>Dear {{ucwords($user->first_name)}}</p>
<br>
<p>We have received your request to reset your password. Please click on the link below in order to proceed.</p>
<br>
<p>Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>
<br>
<strong>Your LocalHood Team</strong>
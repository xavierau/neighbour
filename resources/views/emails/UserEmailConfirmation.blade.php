<p>Dear {{ucwords($user->first_name)}} </p>
<p>Thanks for and As a welcome gift by "Congratulations once again for joining the LocalHood community of {{$user->clan->label}}.</p>
<p>You need to confirm your account to fully activate your LocalHood account and access your LocalHood building network.</p>
<p>Please click  on the button below.</p>
<p><a href="{{ $link = url('email/confirmation').'?token='.$user->email_confirmation_token.'&email='.urlencode($user->email) }}"> {{ $link }} </a></p>

<strong> Your LocalHood Team </strong>
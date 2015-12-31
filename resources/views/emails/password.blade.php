<p>Hello {{ $user->name }},</p>

<p>You have requested a password reset for the TaskManager application.</p>

<p>Click here to reset your password: </p>
{{ url('password/reset/'.$token) }}

<p>Best Regards,<br>
Your Admin</p>
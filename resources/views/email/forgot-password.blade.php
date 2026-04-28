{{-- <x-mail::message> --}}
Hello {{ $user->name }},

Your password reset link!

{{-- <x-mail::button :url="url('reset-password/' . $user->remember_token)"> --}}

Reset Password
{{-- </x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
{{-- </x-mail::message> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Email</title>
</head>

<body>
    <main>
        <p>Hello {{ $user->name }},</p>
        <p>Your password reset link!</p>
        <a href="{{ url('reset-password/' . $user->remember_token) }}">Reset Password</a>
        <br>
        Thanks,<br>
        {{ config('app.name') }}
    </main>
</body>

</html>

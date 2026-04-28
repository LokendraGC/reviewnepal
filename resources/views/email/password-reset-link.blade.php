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
        <title>Password Reset Link</title>
    </head>

    <body>
        <main>
            <p>Hello {{ $user->name }},</p>
            <br>
            <p>Your password reset link! Expire in 5 minutes</p>
            <br>
            <a href="{{ url('reset-password/' . $user->remember_token) }}">Reset Password</a>
            <br>
            Thanks,<br>
            {{ config('app.name') }}
        </main>
    </body>

    </html>

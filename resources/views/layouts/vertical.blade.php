<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])
    @stack('backend-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    @vite(['resources/js/head.js'])
</head>

<body>
    <div class="wrapper">

        @include('layouts.shared/topbar')

        @include('layouts.shared/left-sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')
            </div>
            @include('layouts.shared/footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('layouts.shared/right-sidebar')
    @vite(['resources/js/app.js', 'resources/js/layout.js'])
    @include('layouts.shared/footer-script')

    @stack('backend-js')
    <script>
        function keepSessionAlive() {
            fetch('/keep-session-alive')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.csrf_token;
                    });
                    if (window.axios) {
                        axios.defaults.headers.common['X-CSRF-TOKEN'] = data.csrf_token;
                    }
                })
                .catch(error => console.error('Session refresh error:', error));
        }
        setInterval(keepSessionAlive, 300000);
    </script>
</body>

</html>

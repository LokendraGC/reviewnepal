<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                Last login was {{ auth()->user()->lastLogin() }}.
            </div>
            @php
                $websiteName = SettingHelper::get_field('site_title');
            @endphp
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © {{ $websiteName }} |
                    Developed By <strong><a href="https://webtechnepal.com/" target="_blank">Webtech Nepal</a></strong>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

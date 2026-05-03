{{-- add you js here --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    (function () {
        var toggle = document.getElementById('lang-toggle');
        if (!toggle) {
            return;
        }
        var csrfMeta = document.querySelector('meta[name="csrf-token"]');
        var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : @json(csrf_token());

        toggle.addEventListener('change', function () {
            var lang = this.checked ? 'ne' : 'en';

            fetch(@json(url('/set-language')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ lang: lang })
            })
                .then(function (res) {
                    if (!res.ok) {
                        throw new Error('Request failed');
                    }
                    return res.json();
                })
                .then(function () {
                    location.reload();
                })
                .catch(function () {
                    toggle.checked = !toggle.checked;
                });
        });
    })();
</script>
@stack('frontend-js')
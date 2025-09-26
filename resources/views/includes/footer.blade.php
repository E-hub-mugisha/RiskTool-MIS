<footer class="footer bg-white py-3">
    <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/') }}">
                        {{ config('app.name', 'Disaster Relief Resources Allocation Information System') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Privacy Policy</a>
                </li>
            </ul>
        </nav>

        <div class="text-muted small">
            &copy; {{ date('Y') }} {{ config('app.name', 'Disaster Relief Resources Allocation Information System') }}. All rights reserved.
        </div>

    </div>
</footer>

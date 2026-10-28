<nav class="top-navbar d-flex justify-content-between align-items-center px-4 py-3">
    <h5 class="mb-0">@yield('title', 'Dashboard')</h5>

    <div class="dropdown">
        <a href="#" class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-5"></i> {{ auth()->user()->name }}
            <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
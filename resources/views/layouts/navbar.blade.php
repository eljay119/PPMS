<!-- filepath: d:\Procurement\procurement\resources\views\layouts\navbar.blade.php -->
<nav class="sb-topnav navbar navbar-expand navbar-light fixed-top" style="background-color: #0d6efd; z-index: 1040;">
    <a class="navbar-brand ps-3 d-flex align-items-center text-white" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/bisu.png') }}" alt="BISU Logo" style="width: 40px; height: 40px; margin-right: 10px;">
        @if (Auth::check())
            <span class="text-white">
                {{ Auth::user()->role->name ?? 'Guest' }}
            </span>
        @else
            <span class="text-white">Guest</span>
        @endif
    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars text-white"></i>
    </button>
    <ul class="navbar-nav ms-auto d-flex align-items-center">

        @php
            $user = Auth::user();
            $notifications = collect();
            $notificationCount = 0;

            if ($user && $user->role && $user->role->name === 'Head') {
                $notifications = $user->unreadNotifications;
                $notificationCount = $notifications->count();
            }
        @endphp

        @if ($user && $user->role && $user->role->name === 'Head')
            <li class="nav-item dropdown me-3">
                <a class="nav-link text-white position-relative" id="notificationDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if ($notificationCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notificationCount }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="z-index: 1050;">
                    <li>
                        <h6 class="dropdown-header">Notifications</h6>
                    </li>
                    @if ($notificationCount > 0)
                        @foreach ($notifications as $notification)
                            <li>
                                <a class="dropdown-item" href="{{ $notification->data['link'] ?? '#' }}">
                                    {{ $notification->data['message'] ?? 'No message' }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <span class="dropdown-item text-muted">No new notifications</span>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- User Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" id="navbarDropdown" href="#"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/{{ Auth::user()->profile_pic ?: asset('icons/image.png') }}"
                    alt="Profile picture of {{ Auth::user()->name }}" class="rounded-circle border border-secondary"
                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                @auth
                    <span class="text-white">{{ Auth::user()->name }}</span>
                @else
                    <span class="text-white">Guest</span>
                @endauth
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" style="z-index: 1050;">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-circle me-2 text-primary"></i>Profile
                    </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <button type="button" class="dropdown-item" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt me-2 text-danger"></i>Logout
                        </button>
                    </form>

                    <script>
                        function confirmLogout() {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You will be logged out of the system.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#0d6efd',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Log out',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('logoutForm').submit();
                                }
                            });
                        }
                    </script>
                </li>
            </ul>
        </li>
    </ul>
</nav>



<!-- Add this to your scripts section -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // This ensures the dropdown will work properly
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });

        // This fixes any click event issues
        document.querySelectorAll('.dropdown-menu').forEach(function(element) {
            element.addEventListener('click', function(e) {
                // Prevent click on dropdown menu from closing it unless it's a form button
                if (!e.target.classList.contains('dropdown-item')) {
                    e.stopPropagation();
                }
            });
        });
    });
</script>

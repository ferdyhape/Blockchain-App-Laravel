<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        {{-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> --}}
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                        class="nav_logo-name">BBBootstrap</span>
                </a>
                <div class="nav_list">
                    <a href="{{ route('dashboard.admin.index') }}"
                        class="nav_link {{ checkClassIsActive('dashboard.admin.index') }}">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
                    <a href="{{ route('dashboard.admin.user-management.index') }}"
                        class="nav_link {{ checkClassIsActive('dashboard.admin.user-management.index') }}"> <i
                            class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> </a>
                    <a href="{{ route('dashboard.admin.company-management.index') }}"
                        class="nav_link {{ checkClassIsActive('dashboard.admin.company-management.index') }}"> <i
                            class='bx bx-buildings nav_icon'></i> <span class="nav_name">Company</span>
                    </a> <a href="#" class="nav_link"> <i class='bx bx-bookmark nav_icon'></i> <span
                            class="nav_name">Bookmark</span> </a>
                    <a href="#" class="nav_link"> <i class='bx bx-folder nav_icon'></i> <span
                            class="nav_name">Files</span> </a>
                    <a href="#" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span
                            class="nav_name">Stats</span> </a>
                </div>

            </div>
            <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none">
                @csrf
            </form>

            <a href="#" id='logout-btn' class="nav_link"> <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
        @yield('content')
    </div>
    <!--Container Main end-->
</body>

<script>
    $(document).ready(function() {
        $('#logout-btn').on('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit();
                }
            });
        });
    });
</script>

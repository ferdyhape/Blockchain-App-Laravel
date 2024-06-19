@php
    $sidebarData[] = getSidebarData();
@endphp

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="btn btn-sm btn-primary">
            {{ auth()->user()->name }}
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav-template">
            <div>
                <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                        class="nav_logo-name">
                        {{ config('app.name') }}
                    </span>
                </a>
                <div class="nav_list">
                    @foreach ($sidebarData[0] as $sidebar)
                        @hasrole($sidebar['role'])
                            <x-anchorSidebar route="{{ $sidebar['route'] }}" icon="{{ $sidebar['icon'] }}"
                                name="{{ $sidebar['name'] }}" />
                        @endhasrole
                    @endforeach
                </div>

            </div>
            <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none">
                @csrf
            </form>

            <a href="#" id='logout-btn' class="nav_link"> <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">Logout</span> </a>
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

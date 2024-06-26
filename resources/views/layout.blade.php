<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etan-Employee</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{--
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
</head>
<body>
    <section class="sidebar-navbar-content">
        <section>
            <div class="sidebar">
                <div class="company-name">
                    <div>ETAN CONSTRUCTION</div>
                    <div class="finishing-team">FINISHING TEAM</div>
                </div>
                <div class="sidebar-menu">
                    <ul>
                        <li >
                            <a href="{{ route('employee-dashboard') }}" class="{{ Request::routeIs('employee-dashboard') || Request::routeIs('employee.details') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M8 17q.425 0 .713-.288T9 16t-.288-.712T8 15t-.712.288T7 16t.288.713T8 17m0-4q.425 0 .713-.288T9 12t-.288-.712T8 11t-.712.288T7 12t.288.713T8 13m0-4q.425 0 .713-.288T9 8t-.288-.712T8 7t-.712.288T7 8t.288.713T8 9m3 8h6v-2h-6zm0-4h6v-2h-6zm0-4h6V7h-6zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-2h14V5H5zM5 5v14z"/></svg>
                                <p class="sidebar-text">Employee List</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employee.add') }}" class="{{ Request::routeIs('employee.add') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M18 14v-3h-3V9h3V6h2v3h3v2h-3v3zm-9-2q-1.65 0-2.825-1.175T5 8t1.175-2.825T9 4t2.825 1.175T13 8t-1.175 2.825T9 12m-8 8v-2.8q0-.85.438-1.562T2.6 14.55q1.55-.775 3.15-1.162T9 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T17 17.2V20zm2-2h12v-.8q0-.275-.137-.5t-.363-.35q-1.35-.675-2.725-1.012T9 15t-2.775.338T3.5 16.35q-.225.125-.363.35T3 17.2zm6-8q.825 0 1.413-.587T11 8t-.587-1.412T9 6t-1.412.588T7 8t.588 1.413T9 10m0 8"/></svg>
                                <p class="sidebar-text">Add Employee</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="content-navbar">
            <div class="navbar">
                <div class="hamburger-menu">
                    <svg class="menu" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z"/></svg>
                </div>
                <div class="page-name">
                    <h1>{{ $Title }}</h1>
                </div>
                <div class="user">
                    <div class="name-role">
                        <h1 class="name">{{ $user->first_name }} {{ $user->surname }}</h1>
                        <p class="role">
                            @if($user->role == 1)
                                Admin
                            @elseif($user->role == 2)
                                Employee
                            @else
                                Guest
                            @endif
                        </p>
                    </div>
                    @if($user->image == null)
                        <svg class="image" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1M3 12c0 2.09.713 4.014 1.908 5.542A8.986 8.986 0 0 1 12.065 14a8.984 8.984 0 0 1 7.092 3.458A9 9 0 1 0 3 12m9 9a8.963 8.963 0 0 1-5.672-2.012A6.992 6.992 0 0 1 12.065 16a6.991 6.991 0 0 1 5.689 2.92A8.964 8.964 0 0 1 12 21"/></g></svg>
                    @else
                        <img src="" alt="" class="{{ $user->image }}">
                    @endif

                </div>
            </div>
            <div class="content">
                @yield('contents')
            </div>
        </section>
    </section>
</body>
    @yield('script')
    <script>
        const toggleSidebar = document.querySelector('.hamburger-menu');
        const sidebar = document.querySelector('.sidebar');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarTextsA = document.querySelectorAll('.sidebar-menu li a');

        let isLogoOriginal = true;

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('close');
            sidebarTexts.forEach(sb_text => {
                sb_text.classList.toggle('close');
            });
            sidebarTextsA.forEach(sb_textA => {
                sb_textA.classList.toggle('close');
            });
        });

        @if(session('no-back'))
            {{ session()->forget('no-back') }}
            window.history.replaceState(null, '', '{{ route('employee-dashboard') }}');
        @endif

    </script>
</html>

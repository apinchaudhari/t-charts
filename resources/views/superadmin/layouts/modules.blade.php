<html lang="{{ app()->getLocale() }}">

    @include('superadmin.partials.modules.head')

    <body id="leftMenu" class="superadmin-body g-sidenav-show g-sidenav-pinned">
        @stack('body_start')

        @include('superadmin.partials.admin.menu')

        <div class="main-content" id="panel">

            @include('superadmin.partials.admin.navbar')

            <div id="main-body">

                @include('superadmin.partials.admin.header')

                <div class="container-fluid content-layout mt--6">

                    @include('superadmin.partials.admin.content')

                    @include('superadmin.partials.admin.footer')

                </div>

            </div>

        </div>

        @stack('body_end')

        @include('superadmin.partials.admin.scripts')
    </body>

</html>

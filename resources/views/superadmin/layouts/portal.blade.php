<html lang="{{ app()->getLocale() }}">

    @include('superadmin.partials.portal.head')

    <body id="leftMenu" class="superadmin-body g-sidenav-show g-sidenav-pinned">
        @stack('body_start')

        @include('superadmin.partials.portal.menu')

        <div class="main-content" id="panel">

            @include('superadmin.partials.portal.navbar')

            <div id="main-body">

                @include('superadmin.partials.portal.header')

                <div class="container-fluid content-layout mt--6">

                    @include('superadmin.partials.portal.content')

                    @include('superadmin.partials.portal.footer')

                </div>

            </div>

        </div>

        @stack('body_end')

        @include('superadmin.partials.portal.scripts')
    </body>

</html>

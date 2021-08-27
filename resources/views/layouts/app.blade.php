
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/cryptocurrency-icons.css') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/plugins.css') }}">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/helper.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="{{ asset('assets/css/style-primary.css') }}">

    <style lang="">
        body {
            padding: 10px;
        }

        /* Apply & remove to fix dynamic content scroll issues on iOS 9.0 */
        .modal-scrollfix.modal-scrollfix {
            overflow-y: hidden;
        }

    </style>

    @livewireStyles
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>

<body>

    <div class="main-wrapper">


        <!-- Header Section Start -->
        @include('header')
        <!-- Header Section End -->

        <!-- Side Header Start -->
        @include('sidenav')
        <!-- Side Header End -->

        <!-- Content Body Start -->
        <div class="content-body" id="app">

            @yield('body')

        </div>
        <!-- Content Body End -->

        <!-- Footer Section Start -->
        @include('footer')
        <!-- Footer Section End -->

    </div>

    <!-- JS
============================================ -->

    <!-- Global Vendor, plugins & Activation JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-confirmation.min.js') }}"></script>
    <!--Plugins JS-->
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tippy4.min.js.js') }}"></script>
    <!--Main JS-->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Plugins & Activation JS For Only This Page -->

    <!--Moment-->
    <script src="{{ asset('assets/js/plugins/moment/moment.min.js') }}"></script>

    <!--Daterange Picker-->
    <script src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.active.js') }}"></script>

    <!--Echarts-->
    <script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs/chartjs.active.js') }}"></script>

    <!--VMap-->
    <script src="{{ asset('assets/js/plugins/vmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vmap/maps/samples/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vmap/vmap.active.js') }}"></script>


    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/select2.active.js') }}"></script>


    <script src="{{ asset('assets/js/plugins/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/filepond/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/filepond/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/filepond/filepond.active.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropify/dropify.active.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '[data-toggle="modal"]', function () {
                url = $(this).data("remote")
                console.log(url)
                $($(this).data("target") + ' .modal-body').load(url);
            });

            $('#confirmationModal').on('show.bs.modal', function (e) {
                $(this).find('.confirm').attr('href', $(e.relatedTarget).data('href'));
            });
        });

         $('.toggle-switch').change(function(){
            cb = $(this);
            cb.val(cb.prop('checked'));
        });


        $('.dropify').dropify();

    </script>
    @yield('page_js')

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>

    @stack('scripts')

</body>

</html>


<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                loading...
            </div>
            <!-- <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">Close</button>
                <button class="button button-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Confirmation modal -->
<div class="modal fade" id="confirmationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary confirm">Confirm</a>
            </div>
        </div>
    </div>
</div>

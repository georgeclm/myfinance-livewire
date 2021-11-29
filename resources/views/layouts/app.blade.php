<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src=" https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"
        data-turbolinks-track="true">
    </script>
    @livewireScripts
    <meta name="google-site-verification" content="6KrY7l9rhFc8hI1ofqAJ1l6oyMto4xPpvxundNwI2vg" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/logoicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        data-turbolinks-track="true">
    <link rel="stylesheet" href="{{ asset('css/simple-notify.min.css') }}" data-turbolinks-track="true" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" data-turbolinks-track="true" />
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet" data-turbolinks-track="true">

    @yield('style')
    <style>
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: rgb(33, 33, 33);

        }

        ::-webkit-scrollbar {
            width: 8px;
            background-color: rgb(33, 33, 33);

        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: rgb(170, 170, 170);

        }

        input[type="text"][disabled],
        input[type="number"][disabled],
        select[disabled],
        select option[disabled] {
            background-color: rgb(61, 61, 61) !important;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        select option {
            background-color: rgb(33, 33, 33) !important;
        }

        .scrollable {
            height: auto;
            max-height: 400px;
            overflow-y: auto !important;
        }

        .mobile {
            margin-left: 0 !important;
            padding-right: 0 !important;
        }

        @media screen and (max-width: 768px) {
            .mobile-small {
                font-size: 80%;
            }

            .mb-3-when-small {
                margin-bottom: 1rem;
            }

            .small-when-0 {
                padding: 0 !important;
            }

            .small-when-1 {
                padding: 0.5rem !important;
            }

            .only-big {
                display: none !important;
            }
        }

        .add-button {
            position: fixed;
            right: 1rem;
            bottom: 4rem;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #4e73df;
            background: #f8f9fc;
            line-height: 46px;
        }

        .add-button:hover {
            background: rgb(33, 33, 33);
        }

        .add-button i {
            font-weight: 800;
        }

        .select2-search {
            background-color: rgb(61, 61, 61) !important;
            /* border: 0 !important; */
            /* padding: 0.5rem !important */
        }

        .select2-search input {
            background-color: rgb(61, 61, 61) !important;
            border: 0 !important;
            padding: 0.5rem !important
        }

        .select2-results {
            background-color: rgb(33, 33, 33) !important;
            border: 0 !important;
            color: white !important;
            padding: 0.5rem !important
        }

        .select2-choice {
            background-color: rgb(33, 33, 33) !important;
            border: 0 !important;
            padding: 0.5rem !important
        }

        .select2-container--default .select2-selection--single {
            background-color: rgb(33, 33, 33) !important;
            border: 0 !important;
            /* padding: 0.5rem !important */
        }

        .select2-search--dropdown {
            background-color: rgb(33, 33, 33) !important;
            padding: 0.5rem !important
        }

        .select2-search__field {
            background-color: rgb(33, 33, 33) !important;
            padding: 0.5rem !important
        }

        .select2 {
            background-color: rgb(33, 33, 33) !important;
            padding: 0.5rem !important
        }

        .select2 .select2-selection__rendered {
            color: rgb(170, 170, 170) !important;
        }

        /*=============== MODAL ===============*/

        .modaltest {
            height: 100vh;
            display: grid;
            place-items: center;
        }

        .modal__button {
            display: inline-block;
            background-color: hsl(240, 16%, 18%);
            color: #FFF;
            padding: 1rem 1.25rem;
            border-radius: .5rem;
            transition: .3s;
        }

        .modal__button:hover {
            background-color: hsl(240, 16%, 12%);
        }

        .modal__container {
            position: fixed;
            top: 0;
            left: 0;
            background-color: hsla(0, 0%, 1%, 0.664);
            width: 100%;
            height: 100%;
            display: grid;
            align-items: flex-end;
            overflow: hidden;
            transition: all .3s;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;

            /*=== Effect 3 ===*/
            /* perspective: 1000px; */
        }

        .modal__content {
            position: relative;
            background-color: #FFF;
            /* padding: 3rem 2rem 2rem; */
            border-radius: 1rem 1rem 0 0;
            transition: all .3s;
            padding-bottom: 10px !important;
            /*=== Effect 1 ===*/
            transform: translateY(10%);

            /*=== Effect 2 ===*/
            /* transform: scale(.5) translateY(10%); */

            /*=== Effect 3 ===*/
            /* transform: rotateX(65deg) scale(.75) translateY(10%);
  transform-origin: 50% 100%; */
        }

        .modal__img {
            width: 150px;
            margin-bottom: .75rem;
        }

        .modal__close {
            display: inline-flex;
            background-color: hsl(240, 16%, 18%);
            border-radius: .25rem;
            color: #FFF;
            font-size: 1.5rem;
            position: absolute;
            top: 2rem;
            right: 2rem;
            cursor: pointer;
        }

        .modal__title {
            font-size: 1.5rem;
            color: hsl(240, 8%, 15%);
            font-weight: 500;
        }

        .modal__description {
            margin-bottom: 1.5rem;
        }

        .modal__button-width {
            width: 90%;
        }

        .modal__button-link {
            display: block;
            margin: 1rem auto 0;
            background-color: transparent;
            color: hsl(240, 16%, 18%);
            font-weight: 500;
        }

        /* Show modal */
        .show-modal {
            visibility: visible;
            opacity: 1;

        }

        .show-modal .modal__content {
            /*=== Effect 1 ===*/
            transform: translateY(0);

            /*=== Effect 2 ===*/
            /* transform: scale(1) translateY(0); */

            /*=== Effect 3 ===*/
            /* transform: rotateX(0) scale(1) translateY(0); */
        }

        /*=============== BREAKPOINTS ===============*/
        /* For small devices */
        @media screen and (min-width: 576px) {
            .modal__content {
                margin: auto;
                width: 500px;
                border-radius: 1.25rem !important;
            }

            .modal__img {
                width: 170px;
            }
        }


        /* #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        } */

        #loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: 200px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #9370DB;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #BA55D3;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #FF00FF;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

    </style>
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
        data-turbolinks-track="true" />
</head>

<body id="page-top" class="bg-dark">
    @if (!in_array(Route::current()->uri, ['login', 'register']))
        <!-- Page Wrapper -->
        <div id="wrapper">
            @livewire('sidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content " class="bg-black">
                    @livewire('topbar')
                    <!-- Begin Page Content -->
                    <br>
                    {{ $slot }}
                    <br><br><br><br><br>
                    @livewire('footer')
                </div>
            </div>
        </div>
        @if (!in_array(Route::current()->uri, ['login', 'register']))
            @if (!auth()->user()->rekenings->isEmpty() &&
    !in_array(Route::current()->uri, ['transactions', 'repetitions']))
                <a class="add-button rounded-circle" onclick="showModal('createTransaction')" href="javascript:void(0)">
                    <i class="fas fa-plus"></i>
                </a>
                @livewire('transaction.quick-add')
            @endif
            <a class="only-big scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        @endif
    @else
        {{ $slot }}
    @endif


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"
        data-turbolinks-track="true">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"
        integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ=="
        crossorigin="anonymous" data-turbolinks-track="true"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/sb-admin-2.min.js') }}" data-turbolinks-track="true"></script>
    {{-- <script src="{{ asset('js/Chart.min.js') }}" data-turbolinks-track="true"></script>
    <script src="{{ asset('js/demo/chart-area-demo.js') }}" data-turbolinks-track="true"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js ') }}" data-turbolinks-track="true"></script> --}}
    <script src="{{ asset('js/simple-notify.min.js') }}" data-turbolinks-track="true"></script>
    {{-- <script src="{{ asset('js/polyfiller.js') }}" data-turbolinks-track="true"></script> --}}
    <script>
        $.noConflict(extreme)
        // webshims.cfg.no$Switch = true;
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
        data-turbolinks-track="true"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
        data-turbolinks-track="true"></script>
    <script>
        window.livewire.on('hideEdit', () => {
            closeModal('editModal');
        });
        window.livewire.on('hideCreatePocket', () => {
            closeModal('new-pocket');
        });
        window.livewire.on('hideCreateTransaction', () => {
            closeModal('createTransaction');
        });
        window.livewire.on('editModal', () => {
            showModal('editModal');
        });
        window.livewire.on('deleteModal', () => {
            showModal('deleteModal');
        });
        window.livewire.on('hideDelete', () => {
            closeModal('deleteModal');
        });
        window.livewire.on('adjustModal', () => {
            showModal('adjustModal');
        });
        window.livewire.on('hideAdjust', () => {
            closeModal('adjustModal');
        });
        window.livewire.on('editmodalEmergency', () => {
            showModal('editmodalEmergency');
        });
        window.livewire.on('hideeditmodalEmergency', () => {
            closeModal('editmodalEmergency');
        });
        window.livewire.on('editmodalFund', () => {
            showModal('editmodalFund');
        });
        window.livewire.on('hideeditmodalFund', () => {
            closeModal('editmodalFund');
        });
        window.livewire.on('editmodalSaving', () => {
            showModal('editmodalSaving');
        });
        window.livewire.on('hideeditmodalSaving', () => {
            closeModal('editmodalSaving');
        });
        window.livewire.on('modalEmergency', () => {
            showModal('modalEmergency');
        });
        window.livewire.on('hidemodalEmergency', () => {
            closeModal('modalEmergency');
        });
        window.livewire.on('modalFund', () => {
            showModal('modalFund');
        });
        window.livewire.on('hidemodalFund', () => {
            closeModal('modalFund');
        });
        window.livewire.on('modalSaving', () => {
            showModal('modalSaving');
        });
        window.livewire.on('hidemodalSaving', () => {
            closeModal('modalSaving');
        });
        window.livewire.on('run', () => {
            run();
        });
        /*=============== SHOW MODAL ===============*/
        var showModal = (modalContent) => {
            const modalContainer = document.getElementById(modalContent)
            const bottomNav = document.getElementById('bottom-nav')
            bottomNav.classList.add('d-none')
            modalContainer.classList.add('show-modal')
        }
        var closeModal = (modalContent) => {
            const modalContainer = document.getElementById(modalContent)
            const bottomNav = document.getElementById('bottom-nav')
            bottomNav.classList.remove('d-none')
            modalContainer.classList.remove('show-modal')
        }
        $('#new-user').modal('show');

        @auth
            @if (!auth()->user()->rekenings->isEmpty() &&
                !in_array(Route::current()->uri, ['transactions', 'repetitions']))
                $('#category_id').hide("slow");
                $('#category_masuk_id').hide("slow");
                $('#keterangan').hide("slow");
                $('#rekening_id').hide("slow");
                $('#jumlah').hide("slow");
                $('#jenisuang').on('change', function(e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                $('input').prop('disabled', false);
                $('select').prop('disabled', false);
                $('#category_id').prop('required', false);
                $('#category_masuk_id').prop('required', false);
                $('#category_id').hide("slow");
                $('#category_masuk_id').hide("slow");
                $('#keterangan').show("slow");
                $('#rekening_id').show("slow");
                $('#jumlah').show("slow");
                if (valueSelected == 1) {
                $('#category_masuk_id').show("slow");
                $('#category_masuk_id').prop('required', true);
                } else if (valueSelected == 2) {
                $('#category_id').show("slow");
                $('#category_id').prop('required', true);
                } else if (valueSelected == 4) {} else if (valueSelected == 3) {} else {}
                });
            @endif
        @endauth
        $(function() {
            var start = moment().startOf('month');
            var end = moment().endOf('month').add(1, 'days');
            $('input[name="daterange"]').daterangepicker({
                startDate: start,
                endDate: end,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " / ",
                },
                opens: 'center',
                ranges: {
                    'Today': [moment(), moment().add(1, 'days')],
                    'Yesterday': [moment().subtract(1, 'days'), moment()],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month').add(1, 'days')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')]
                }
            }, function(start, end, label) {
                // $('#date_submit').submit();
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });

        function run() {

            document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPostion = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLenght = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {
                        this.value = value.toLocaleString('id-ID', {
                            currency: 'IDR',
                            style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPostion = this.value.length - originalLenght + cursorPostion;
                        this.setSelectionRange(cursorPostion, cursorPostion);
                    }
                });
            });
        }
        run();

        function myFunction() {
            var x = document.getElementById("myInput");
            var y = document.getElementById("myInput2");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
    @yield('script')
    <script>
        Livewire.on('error', message => {
            new Notify({
                status: 'error',
                title: 'Error',
                text: message,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 2,
                position: 'right top'
            })
        })
        Livewire.on('success', message => {
            new Notify({
                status: 'success',
                title: 'Success',
                text: message,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 2,
                position: 'right top'
            })
        })
    </script>
</body>

</html>

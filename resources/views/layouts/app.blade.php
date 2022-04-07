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
        .nav-link:hover,
        .collapse-item:hover,
        .nav-item.active,
        .collapse-item.active {
            background-color: rgb(61, 61, 61) !important;
        }

        .add-button {
            position: fixed;
            right: 1rem;
            bottom: 4.75rem;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #4e73df;
            background: #f8f9fc;
            line-height: 46px;
        }

        .modal.custom .modal-dialog {
            width: 100%;
            position: fixed;
            bottom: 0;
            margin: 0;
        }
        .modal.fade .modal-dialog {
            transform: translate3d(0, 0%, 0);
        }

        .modal.in .modal-dialog {
            transform: translate3d(0, 0, 0);
        }
    </style>
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
        data-turbolinks-track="true" />
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
</head>

<body id="page-top " class="bg-dark">
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
        window.livewire.on('CreatePocket', () => {
            showModal('new-pocket');
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
        window.livewire.on('thechart', () => {
            thechart();
            chart2();
        });
        window.livewire.on('refresh-chart', () => {
            refreshChart()
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

</body>

</html>

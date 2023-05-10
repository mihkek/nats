@section('title', 'Служба поддержки')
@extends('admin.template')
@section('main')

    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <style>

        {{-- исправления ticketit чтобые не влезать в их шаблоны --}}
        .nav-pills, .nav-tabs {
            margin-bottom: 0px;
        }
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            content: "";
        }

    </style>



    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="alert-area"></div>

            <div id="app">
                <main class="py-4">
                    @yield('auth_content')
                    @yield('content')
                </main>
            </div>

        </div>
    </div>



@endsection
@push('scripts')
    @yield('footer')
@endpush

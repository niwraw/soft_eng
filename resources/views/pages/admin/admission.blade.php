<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        @include('components.dashboard.header')

        <div class="grid" style="grid-template-columns: 1fr 5fr;">
            @include('components.dashboard.sidebar')

            @if ($currentRoute === 'dashboard')
                @include('pages.admin.sections.dashboard')
            @elseif ($currentRoute === 'applicants')
                @include('pages.admin.sections.applicants')
            @elseif ($currentRoute === 'announcements')
                @include('pages.admin.sections.announcement')
            @elseif ($currentRoute === 'attendance')

            @elseif ($currentRoute === 'result')

            @endif
        </div>
    </body>

    <script type="text/javascript">
        var male = JSON.parse('{!! json_encode($maleApplicants) !!}');
        var female = JSON.parse('{!! json_encode($femaleApplicants) !!}');
        var count = JSON.parse('{!! json_encode($count) !!}');
        var currentStatus = JSON.parse('{!! json_encode($status) !!}');
        var regions = JSON.parse('{!! json_encode($regions) !!}');
        var manilaRatio = JSON.parse('{!! json_encode($manilaRatio) !!}');
        var inactive = JSON.parse('{!! json_encode($inactive) !!}');
        var strand = JSON.parse('{!! json_encode($strands) !!}');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="{{ asset('../assets/js/adminDashboard/initial_admission.js') }}"></script>
    <script>
        function confirmRestore() {
            return confirm('Are you sure you want to restore Inactive Applicants?');
        }

        function confirmArchive() {
            return confirm('Are you sure you want to archive Inactive Applicants?');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete Inactive Applicants? Total Count: ' + inactive);
        }
    </script>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Med clinic')</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

@yield('content')

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/index.global.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2()

        $(function () {
            bsCustomFileInput.init();
        });

        let invalidFields = @json($errors->keys());

        invalidFields.forEach(function (field) {
            let element = $(`#${field}`);
            if (element.hasClass('select2-hidden-accessible')) {
                element.next('.select2-container').addClass('is-invalid');
            }
        });
    });
</script>

<style>
    .select2-container.is-invalid .select2-selection {
        border: 1px solid #dc3545;
        border-radius: 0.25rem;
    }
</style>
</body>
</html>

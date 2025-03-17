@if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('info'))
        <script>
            toastr.info('{{ session('info') }}');
        </script>
    @endif

    @if (session('warning'))
        <script>
            toastr.warning('{{ session('warning') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if (session('failed'))
        <script>
            toastr.error('{{ session('failed') }}');
        </script>
    @endif

    @if (session('errors'))
        @foreach (session('errors') as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif
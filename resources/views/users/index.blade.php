<x-layout>
    <div class="container">
        <div class="row my-4 mx-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Usuarios</h1>
                <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline">Agregar</span>
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="table-responsive">
                <table id="usersTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th class="text-end text-nowrap w-auto">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DataTables carga los datos vía AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        $('#usersTable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route("users.data") }}',
                type: 'GET'
            },
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            pageLength: 10,
            lengthMenu: [[10,25,50,100],[10,25,50,100]],
        });

        function execute(url) {
            window.open(url, '_self');
        }

        function deleteRecord(url) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                $('<form>', {'action': url, 'method': 'POST'})
                .append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}))
                .append($('<input>', {type: 'hidden', name: '_method', value: 'DELETE'}))
                .appendTo('body')
                .submit()
                .remove();
            }
        }

        @if (session('success'))
            alert(`{{ session('success') }}`);
        @endif
    </script>
    @endsection
</x-layout>
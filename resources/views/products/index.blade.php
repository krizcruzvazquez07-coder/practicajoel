<x-layout>
    
    <?php
        //$products = [
            //['id' => 1, 'name' => 'CocaCola1l', 'description' => 'Coca cola de 1 litro', 'price' => 45.00],
        //];
    ?>
    <div class="container">
        <div class="row my-4 mx-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Productos</h1>
                <button class="btn btn-primary btn-sm" onclick="execute('/productos/agregar')">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline">Agregar</span>
                </button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th class="text-end text-nowrap w-auto">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['description'] }}</td>
                                <td>${{ number_format($product['price'], 2) }}</td>
                                <td class="text-end text-nowrap w-auto">
                                    <button class="btn btn-primary btn-sm" onclick="execute('/products/{{ $product['id'] }}/edit')">

                                        <i class="bi bi-pencil"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteRecord('/products/{{ $product['id'] }}/delete')">
                                        <i class="bi bi-trash"></i>
                                        <span class="d-none d-sm-inline">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        new DataTable('#myTable');
        function execute(url) {
            window.location.href = url;
        }
        @if (session('success'))
      alert( '{{ session('success')}}');
      @endif
    </script>
    @endsection

</x-layout>

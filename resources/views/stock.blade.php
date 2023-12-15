@extends('templates.template1')
@section('content')
    <div class="bg-white">
        <div class="container-fluid py-3 px-5">
            <div class="row">
                <div class="col d-flex align-items-center justify-content-center">
                    <h1>PRODUCTS AVAILABLE</h1>
                </div>
            </div>
            <div class="container-fluid shadow-lg rounded p-2">
                <div class="col pb-4">
                    <div class="row">
                        <table id="example" class="display" data-page-length="15" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase">SKU</th>
                                    <th class="text-center text-uppercase">DESCRIPTION</th>
                                    <th class="text-center text-uppercase">STOCK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $product->sku }}</td>
                                        <td class="text-center">{{ $product->description }}</td>
                                        <td class="text-center">{{ $product->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#example').DataTable({
            dom: 'Bfrtip',
            colReorder: true,
            responsive: true,
            pagingType: "full_numbers",
            order: [[2,"desc"]],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'stock',
                    title: ''
                },
                {
                    extend: 'csvHtml5',
                    filename: 'stock',
                    title: ''
                }
            ],
        });
    </script>
@endsection

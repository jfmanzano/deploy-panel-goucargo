@php
    use App\Models\OrderLines;
    use App\Models\Producto;
@endphp
@extends('templates.template1')
@section('content')
    <div class="bg-white">
        <div class="container-fluid py-3 px-3">
            <div class="row">
                <div class="col d-flex align-items-center justify-content-center">
                    <h1>ORDER STATUS</h1>
                </div>
            </div>
            <div class="shadow-lg rounded p-2">
                <div class="col pb-4">
                    <div class="row">
                        <table id="example" class="display" data-page-length="13" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase">Order Code</th>
                                    <th class="text-center text-uppercase">Goucargo Order Code</th>
                                    <th class="text-center text-uppercase">Status Text</th>
                                    <th class="text-center text-uppercase">Last Update Date</th>
                                    <th class="text-center text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processedOrderStatus as $product)
                                    <tr>
                                        <td class="text-center">{{ $product[0]->order_code }}</td>
                                        <td class="text-center">
                                            {{ $product[0]->order_code_nav == null ? 'NOT ASSIGNED' : $product[0]->order_code_nav }}
                                        </td>
                                        <td class="text-center">
                                            {{ $product[0]->status_text == null ? 'NOT ASSIGNED' : $product[0]->status_text }}
                                        </td>
                                        <td class="text-center">
                                            {{ $product[0]->updated_at }}
                                        </td>
                                        <td class="text-center p-1">
                                            @if ($product[0]->status == 0 || $product[0]->status == 3)
                                                <form action="{{ route('deletedAtOrder', $product[0]->id) }}" method="POST"
                                                    id="formDelete">
                                                    @csrf
                                                    <button type="button" style="text-decoration:none;"
                                                        title="Aditional information" data-bs-toggle="modal"
                                                        data-bs-target="#order{{ $product[0]->id }}"
                                                        class="btn btn-primary">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-danger mx-1" id="borrar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @elseif ($product[0]->status == 2)
                                                <button type="button" style="text-decoration:none;"
                                                    title="Aditional information" title="Aditional information"
                                                    data-bs-toggle="modal" data-bs-target="#order{{ $product[0]->id }}"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    @php
                                        $products = OrderLines::where('order_code', $product[0]->order_code)->get();
                                        $descriptions = [];
                                        foreach ($products as $p) {
                                            $descriptions[$p->sku] = Producto::where('sku', $p->sku)->first();
                                        }
                                    @endphp
                                    <div class="modal fade" id="order{{ $product[0]->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="p-3">
                                                    <div class="mx-auto m-0 p-0">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Order Code:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->order_code }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Client's Order Code:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->client_order_code }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send To Name:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_name }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send To Address:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_address }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send to Zip Code:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_zipcode }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send to Village Neighborhood:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_village_neighborhood }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send to City:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_city }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Send to Phone Number:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->send_to_phone_number }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Goucargo Order Code:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->order_code_nav }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Status text:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->status_text }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">Tracking number:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->tracking_number }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 p-0">
                                                                    <label for="send_to_city" class="form-label">User:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            name="send_to_city"
                                                                            value="{{ $product[0]->user }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="modal-body" id="contenidoModal">
                                                    <div class="row">
                                                        <div class="col-2 text-center">
                                                            <b>PN</b>
                                                        </div>
                                                        <div class="col-8 text-center">
                                                            <b>DESCRIPTION</b>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <b>QUANTITY</b>
                                                        </div>
                                                    </div>
                                                    <div class="bg-black shadow rounded">
                                                        <ul class="list-group">
                                                            @foreach ($products as $prd)
                                                                <li class="list-group-item px-0 m-0">
                                                                    <div class="row">
                                                                        <div class="col-2 text-center">
                                                                            {{ $prd->sku }}
                                                                        </div>
                                                                        <div class="col-8 text-center">
                                                                            {{ $descriptions[$prd->sku] == null ? 'NO DESCRIPTION' : $descriptions[$prd->sku]->description }}
                                                                        </div>
                                                                        <div class="col-2 text-center">
                                                                            {{ $prd->quantity }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            order: [
                [2, "desc"]
            ],
            buttons: [{
                    text: 'ALL',
                    action: function() {
                        var estadoCero = document.createElement("a");
                        estadoCero.href = "{{ route('order-status') }}";
                        estadoCero.click();
                    }
                },
                {
                    text: 'CREATED',
                    action: function() {
                        var estadoCero = document.createElement("a");
                        estadoCero.href = "{{ route('order-status', '0') }}";
                        estadoCero.click();
                    }
                },
                {
                    text: 'PROCCESSED',
                    action: function() {
                        var estado = document.createElement("a");
                        estado.href = "{{ route('order-status', '1') }}";
                        estado.click();
                    }
                },
                {
                    text: 'TRACKED',
                    action: function() {
                        var estado = document.createElement("a");
                        estado.href = "{{ route('order-status', '2') }}";
                        estado.click();
                    }
                },
                {
                    text: 'ERROR',
                    action: function() {
                        var estado = document.createElement("a");
                        estado.href = "{{ route('order-status', '3') }}";
                        estado.click();
                    }
                },

            ]
        });
    </script>
    <script>
        function pregunta() {
            if (confirm('Are you sure to delete this order?')) {
                document.getElementById('formDelete').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('borrar').addEventListener('click', function(e) {
                e.preventDefault();
                pregunta()
            });
        });
    </script>
@endsection

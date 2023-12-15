@extends('templates.template1')
@section('content')
    <div class="bg-white">
        <div class="container-fluid py-2 px-5">
            <div class="d-flex justify-content-start pb-4">
                <div class="col">
                    <div class="row py-3">
                        <div class="col">
                            <div class="row">
                                <div class="col d-flex align-items-center justify-content-center">
                                    <h1>CREATE ORDERS WITH EXCEL</h1>
                                </div>
                            </div>
                            <div class="row shadow-lg rounded p-2">
                                <form action="{{ route('store-order-excel') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 p-0">
                                            <label for="archivo_excel" class="form-label">Select file:</label>
                                            {{-- (<a href="{{ asset('GOUCARGO WEBSERVICE ORDERS TEMPLATE.xlsx') }}">Download
                                                Template</a>) --}}
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="archivo_excel"
                                                    accept=".xlsx, .xls, .csv">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary">CREATE ORDER</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <h1 class="text-center mt-2">CREATE ORDER</h1>
                    </div>
                    <div class="row shadow-lg rounded p-2">
                        <form action="{{ route('store-order') }}" method="POST">
                            @csrf
                            <h6 for="products" class="form-label text-uppercase">Products:</h6>
                            <div id="alert"></div>
                            <div class="col" id="wrapperproducts">
                                <div class="row p-2" id="products">
                                    <div class="col-11">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 p-0">
                                                    <label for="sku0" class="form-label">Item code:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="sku0"
                                                            minlength="5" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 p-0">
                                                    <label for="quantity0" class="form-label">
                                                        Quantity (max.100 units):
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="quantity0"
                                                            min="1" max="100" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 p-0">
                                                    <label for="comment0" class="form-label">Comments (optional):</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="comment0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-warning" id="products-add-button">+</button>
                                    </div>
                                </div>
                            </div>
                            <h6 for="aditional" class="form-label text-uppercase">Aditional parameters:</h6>
                            <div class="row p-2" id="aditional">
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="order_code" class="form-label">Unique order code
                                            assigned:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="order_code" required>
                                        </div>
                                        @error('order_code')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="client_order_code" class="form-label">Internal order code
                                            from customer to your customer (dropshipping only):</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="client_order_code" required>
                                        </div>
                                        @error('client_order_code')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="order_comments" class="form-label">Observations:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="order_comments" required>
                                        </div>
                                        @error('order_comments')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="dropshipping" class="form-label">Dropshipping:</label>
                                        <div class="input-group">
                                            <select class="form-select" name="dropshipping">
                                                <option value="0">0 - Not dropshipping</option>
                                                <option value="1">1 - With dropshipping</option>
                                            </select>
                                        </div>
                                        @error('dropshipping')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_name" class="form-label">Client's name:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_name" required>
                                        </div>
                                        @error('send_to_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_address" class="form-label">Client's address:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_address" required>
                                        </div>
                                        @error('send_to_address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_zipcode" class="form-label">Client's postcode:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_zipcode" required>
                                        </div>
                                        @error('send_to_zipcode')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_village_neighborhood" class="form-label">Client's
                                            town:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                name="send_to_village_neighborhood" required>
                                        </div>
                                        @error('send_to_village_neighborhood')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_city" class="form-label">Client's province:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_city" required>
                                        </div>
                                        @error('send_to_city')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_phone_number" class="form-label">Client's phone:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_phone_number"
                                                required>
                                        </div>
                                        @error('send_to_phone_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="send_to_person" class="form-label">Contact person with
                                            customer:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="send_to_person" required>
                                        </div>
                                        @error('send_to_person')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="transport_code" class="form-label">Carrier's code:</label>
                                        <div class="input-group">
                                            <select class="form-select" name="transport_code">
                                                <option value="1060">1060 - DACHSER PALETS</option>
                                                <option value="2000">2000 - TRANSAHER</option>
                                                <option value="888">888 - DHL PALETS</option>
                                                <option value="537">537 - CABRERO PALETS</option>
                                                <option value="2070">2070 - DACHSER EUROPA PALETS</option>
                                                <option value="902">902 - RECOGE SU AGENCIA</option>
                                                <option value="904">904 - RECOGE SU AGENCIA</option>
                                            </select>
                                        </div>
                                        @error('transport_code')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="delivery_note_type" class="form-label">Delivery Note Type:</label>
                                        <div class="input-group">
                                            <select class="form-select" name="delivery_note_type">
                                                <option value="0">0 - Sin albarán</option>
                                                <option value="1">1 - Albarán valorado en Globomatik</option>
                                                <option value="2">2 - Albarán sin valorar en Globomatik</option>
                                                <option value="3">3 - Albarán valorado de cliente</option>
                                                <option value="4">4 - Albarán sin valorar de cliente</option>
                                            </select>
                                        </div>
                                        @error('delivery_note_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 p-0">
                                        <label for="packaging_type" class="form-label">Packaging type:</label>
                                        <div class="input-group">
                                            <select class="form-select" name="packaging_type">
                                                <option value="0">0 - Neutral</option>
                                                <option value="1">1 - Globomatik</option>
                                                <option value="2">2 - Customized</option>
                                            </select>
                                        </div>
                                        @error('packaging_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3">
                                <button type="submit" class="btn btn-primary">CREATE ORDER</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="script">
        $(document).ready(function() {
            var max_fields = 100;
            var wrapper = document.getElementById('wrapperproducts')
            var add_button = document.getElementById('products-add-button')
            var x = 1
            $(add_button).click(function(e) {
                e.preventDefault()
                if (x < max_fields) {
                    document.getElementById("alert").innerHTML = "";
                    $(wrapper).append(
                        '<div class="row" id="products"><div class="col-11"><div class="row"><div class="col"><div class="mb-3 p-0"><label for="sku' +
                        x +
                        '" class="form-label">Item code:</label><div class="input-group"><input type="text" class="form-control" name="sku' +
                        x +
                        '" minlength="5" required></div></div></div><div class="col"><div class="mb-3 p-0"><label for="quantity' +
                        x +
                        '" class="form-label">Quantity (max. 100 units):</label><div class="input-group"><input type="text" class="form-control" name="quantity' +
                        x +
                        '" min="1" max="100" required></div></div></div></div><div class="row"><div class="col"><div class="mb-3 p-0"><label for="comment' +
                        x +
                        '" class="form-label">Comments (optional):</label><div class="input-group"><input type="text" class="form-control" name="comment' +
                        x +
                        '"></div></div></div></div></div><div class="col-1 d-flex justify-content-center align-items-center"><button type="button" class="btn btn-danger" id="products-remove-button">-</button></div></div>'
                    )
                    x++
                } else {
                    document.getElementById("alert").innerHTML =
                        "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>LIMIT EXCEEDED: </strong>Only 100 products in one order</div>";
                }
            })
            $(wrapper).on('click', '#products-remove-button', function(e) {
                document.getElementById("alert").innerHTML = "";
                e.preventDefault()
                $(this).parent('div').parent('div').remove()
                x--
            })
        })
    </script>
@endsection

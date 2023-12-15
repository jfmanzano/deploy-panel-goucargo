@extends('templates.template1')
@section('content')
    <div class="container-fluid">
        <div class="col p-3">
            <div class="row text-center">
                <h1>EDIT TEMPLATE</h1>
            </div>
            <div class="row">
                <div class="shadow rounded p-2">
                    <form action="{{ route('update-template') }}" method="POST">
                        @csrf
                        <div class="mb-3 p-0">
                            <label for="name" class="form-label">Name: (MIRAKL_TEMPLATE,...)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" value="{{ $template->name }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3 p-0">
                            <label for="customerFields" class="form-label">Customer fields: (field1;field2;...)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="customerFields"
                                    value="{{ $template->customer_fields }}" required>
                            </div>
                        </div>
                        <div class="mb-3 p-0">
                            <label for="ownFields" class="form-label">Own fields:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ownFields"
                                    value="{{$template->own_fields}}"
                                    disabled>
                            </div>
                        </div>
                        <div class="row px-3">
                            <button type="submit" class="btn btn-primary">EDIT TEMPLATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

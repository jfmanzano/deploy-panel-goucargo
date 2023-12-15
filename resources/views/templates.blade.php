@php
    use App\Models\Template;
@endphp
@extends('templates.template1')
@section('content')
    <div class="container-fluid">
        <div class="col py-3">
            <div class="row">
                <div class="col-8 text-center">
                    <div class="row">
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <a class="btn btn-primary" href="{{route('create-template')}}">NEW TEMPLATE</a>
                        </div>
                        <div class="col-10 d-flex justify-content-center">
                            <h1>TEMPLATES</h1>
                        </div>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <h1>USERS TEMPLATES</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="rounded shadow p-2">
                        <table id="example1" class="display" data-page-length="15" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase">ID</th>
                                    <th class="text-center text-uppercase">NAME</th>
                                    <th class="text-center text-uppercase">CUSTOMER FIELDS</th>
                                    <th class="text-center text-uppercase">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $t)
                                    @php
                                        $customerFieldsRaw = $t->customer_fields;
                                        $customerFieldsArray = explode(';', $customerFieldsRaw);
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $t->id }}</td>
                                        <td class="text-center">{{ $t->name }}</td>
                                        <td class="text-center">
                                            @foreach ($customerFieldsArray as $item)
                                                {{ $item }} -
                                            @endforeach
                                        </td>
                                        <td class="text-center"><a class="btn btn-warning" href="{{route('edit-template', $t->id)}}"><i class="bi bi-pencil-square"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4">
                    <div class="rounded shadow p-2">
                        <table id="example2" class="display" data-page-length="15" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase">USER</th>
                                    <th class="text-center text-uppercase">TEMPLATE</th>
                                    <th class="text-center text-uppercase">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $u)
                                    @php
                                        $templateId = $u->template_id;
                                        $templateName = Template::where('id', $templateId)
                                            ->pluck('name')
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $u->user }}</td>
                                        <td class="text-center">{{ $templateName }}</td>
                                        <td class="text-center"><a class="btn btn-warning" href="{{route('edit-user-template', $u->id)}}"><i class="bi bi-pencil-square"></i></a></td>
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
        $('#example1').DataTable({
            dom: 'Bfrtip',
            colReorder: true,
            responsive: true,
            pagingType: "full_numbers",
            order: [
                [0, "asc"]
            ],
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
        $('#example2').DataTable({
            dom: 'Bfrtip',
            colReorder: true,
            responsive: true,
            pagingType: "full_numbers",
            order: [
                [2, "desc"]
            ],
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

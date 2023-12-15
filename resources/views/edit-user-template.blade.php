@extends('templates.template1')
@section('content')
    <div class="container-fluid">
        <div class="col p-3">
            <div class="row text-center">
                <h1>EDIT USER TEMPLATE</h1>
            </div>
            <div class="row">
                <div class="shadow rounded p-2">
                    <form action="{{route('update-user-template')}}" method="POST">
                        @csrf
                        <div class="mb-3 p-0">
                            <label for="user" class="form-label">User:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="user" value="{{ $user->user }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 p-0">
                            <label for="template" class="form-label">Template:</label>
                            <div class="input-group">
                                <select class="form-select" name="template">
                                    @foreach ($templates as $t)
                                        <option value="{{$t->id}}">{{$t->id}} - {{$t->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('packaging_type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row px-3">
                            <button type="submit" class="btn btn-primary">EDIT USER TEMPLATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

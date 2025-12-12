@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Add Governorate</h1>

    <form action="{{ route('admin.governorates.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>

            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Shipping Cost</label>
            <input type="number" name="shipping_cost" step="0.01" class="form-control" required>

            @error('shipping_cost') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Governorate</h1>

    <form action="{{ route('admin.governorates.update', $governorate->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ $governorate->name }}"
                   required>

            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Shipping Cost</label>
            <input type="number"
                   name="shipping_cost"
                   step="0.01"
                   class="form-control"
                   value="{{ $governorate->shipping_cost }}"
                   required>

            @error('shipping_cost') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

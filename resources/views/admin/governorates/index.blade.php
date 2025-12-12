@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Governorates</h1>

    <a href="{{ route('admin.governorates.create') }}" class="btn btn-primary mb-3">
        + Add Governorate
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Shipping Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($governorates as $gov)
            <tr>
                <td>{{ $gov->name }}</td>
                <td>{{ $gov->shipping_cost }} EGP</td>
                <td>
                    <a href="{{ route('admin.governorates.edit', $gov->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.governorates.destroy', $gov->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this?')" 
                                class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $governorates->links() }}
</div>
@endsection

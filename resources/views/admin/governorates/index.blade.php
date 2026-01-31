
@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 shadow-lg rounded-2xl border border-gray-200">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Governorates</h1>
        <a href="{{ route('admin.governorates.create') }}"
           class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg shadow transition">
           + Add Governorate
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto mt-4">
        <table class="w-full text-sm border-collapse rounded-lg overflow-hidden">
            <thead class="bg-pink-50 border-b border-gray-200">
                <tr>
                    <th class="p-3 text-left font-medium text-gray-700">Name</th>
                    <th class="p-3 text-left font-medium text-gray-700">Shipping Cost</th>
                    <th class="p-3 text-center font-medium text-gray-700">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($governorates as $gov)
                    <tr class="hover:bg-pink-50 transition">
                        <td class="p-3 font-semibold text-gray-800">{{ $gov->name }}</td>
                        <td class="p-3 font-medium text-gray-700">{{ number_format($gov->shipping_cost, 2) }} EGP</td>
                        <td class="p-3 text-center space-x-2">

                            <a href="{{ route('admin.governorates.edit', $gov->id) }}"
                               class="px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg text-xs transition">
                               Edit
                            </a>

                            <form action="{{ route('admin.governorates.destroy', $gov->id) }}" 
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Delete this governorate?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg text-xs transition">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No governorates found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $governorates->links() }}
    </div>

</div>
@endsection

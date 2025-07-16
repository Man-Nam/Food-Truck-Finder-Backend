@extends('admin.layouts.app')

@section('title', 'Food Trucks List')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Food Truck Management</h1>
        <a href="{{ route('admin.food_trucks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-sm transition duration-300 ease-in-out">
            Add New Food Truck
        </a>
    </div>

    {{-- Flash messages are now handled in admin.layouts.app --}}

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Type</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Description</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Latitude</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Longitude</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Last Reported At</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Reported By</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Marker Icon</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($foodTrucks as $truck)
                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->id }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->type }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700 max-w-xs overflow-hidden text-ellipsis whitespace-nowrap">{{ $truck->description ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->latitude }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->longitude }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->last_reported_at ? $truck->last_reported_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $truck->reportedBy ? $truck->reportedBy->name : 'Anonymous' }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">
                            @if ($truck->marker_icon_url)
                                <img src="{{ $truck->marker_icon_url }}" alt="Marker" class="w-12 h-12 object-contain rounded-md shadow">
                            @else
                                <span class="text-gray-500">No Icon</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700 flex items-center space-x-2">
                            <a href="{{ route('admin.food_trucks.edit', $truck->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-md shadow-sm transition duration-300 ease-in-out">Edit</a>
                            <form action="{{ route('admin.food_trucks.destroy', $truck->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this food truck?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-md shadow-sm transition duration-300 ease-in-out">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-4 px-4 text-center text-gray-500">No food trucks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $foodTrucks->links('vendor.pagination.tailwind') }} {{-- Use Laravel's built-in Tailwind pagination view --}}
    </div>
</div>
@endsection

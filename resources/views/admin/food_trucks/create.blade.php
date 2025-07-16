@extends('admin.layouts.app')

@section('title', 'Add New Food Truck')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Add New Food Truck</h1>

    <form action="{{ route('admin.food_trucks.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Food Truck Name:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Food Type:</label>
            <input type="text" name="type" id="type" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror" value="{{ old('type') }}" required>
            @error('type')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description (Optional):</label>
            <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            <input type="text" name="latitude" id="latitude" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('latitude') border-red-500 @enderror" value="{{ old('latitude') }}" required>
            @error('latitude')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="text" name="longitude" id="longitude" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('longitude') border-red-500 @enderror" value="{{ old('longitude') }}" required>
            @error('longitude')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="reported_by_user_id" class="block text-gray-700 text-sm font-bold mb-2">Reported By User (Optional):</label>
            <select name="reported_by_user_id" id="reported_by_user_id" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reported_by_user_id') border-red-500 @enderror">
                <option value="">Select User (Anonymous)</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('reported_by_user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
            @error('reported_by_user_id')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-sm transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">
                Add Food Truck
            </button>
            <a href="{{ route('admin.food_trucks.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

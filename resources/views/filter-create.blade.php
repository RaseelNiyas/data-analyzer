<!-- resources/views/filter-create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Filter</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('filter.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="filter_name">Filter Name:</label>
                <input type="text" name="filter_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="filter_type">Filter Type:</label>
                <select name="filter_type" class="form-control" required>
                    <option value="No filter">No filter</option>
                    <option value="Text">Text</option>
                    <option value="Integer">Integer</option>
                    <option value="List">List</option>
                    <option value="Date">Date</option>
                    <option value="Boolean">Boolean</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection

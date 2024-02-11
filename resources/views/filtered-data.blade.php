<!-- resources/views/filtered-data.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Filtered Data</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- Add table headers based on your data structure -->
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Column 3</th>
                    <!-- ... Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                @forelse ($filteredData as $data)
                    <tr>
                        <td>{{ $data->column1 }}</td>
                        <td>{{ $data->column2 }}</td>
                        <td>{{ $data->column3 }}</td>
                        <!-- ... Add more data columns as needed -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No filtered data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

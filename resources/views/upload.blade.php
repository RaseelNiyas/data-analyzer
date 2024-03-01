<!-- resources/views/upload.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Excel File</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('upload.process') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">Select Excel File (.xlsx)</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>

                    <hr>

                    @isset($previewData)
                        <div class="excel-preview" style="height: 400px; overflow-y: auto;">
                            <h4>Preview of Excel File</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        @foreach($previewData[0] as $column)
                                        @if(is_array($column))
                                        @foreach($column as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach
                                    @else
                                        <th>{{ $column }}</th>
                                    @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < count($previewData); $i++)
                                        <tr>
                                            @foreach($previewData[$i] as $value)
                                                <td>
                                                    @if(is_array($value))
                                                        @foreach($value as $item)
                                                            {{ $item }}
                                                        @endforeach
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <!-- Button to open the dynamic filter form -->
                        <button id="show-filter-form-btn" class="btn btn-primary mt-3" data-toggle="modal" data-target="#filterModal">Create Filter</button>

                        <!-- Modal for the dynamic filter form -->
                        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Create Filter</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your dynamic filter form elements here -->
                                        <form id="save-filter-form" action="{{ route('filter.store') }}" method="post">
                                            @csrf
                                            @foreach($previewData[0] as $column)
                                                @php
                                                    $isColumnArray = is_array($column);
                                                    $snakeColumn = Str::snake($isColumnArray ? $column[0] : $column);
                                                @endphp

                                                <div class="row mb-2">
                                                    <div class="col-6">
                                                        <label>{{ $isColumnArray ? $column[0] : $column }}:</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select name="filters[{{ $snakeColumn }}]" class="form-control">
                                                            <option value="no_filter" selected>No Filter</option>
                                                            <option value="text">Text</option>
                                                            <option value="integer">Integer</option>
                                                            <option value="list">List</option>
                                                            <option value="date">Date</option>
                                                            <option value="boolean">Boolean</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <button type="submit" class="btn btn-primary mt-2" id="save-filter-btn">Save Filters</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('download') }}" class="btn btn-success mt-3">Download Original File</a>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showFilterFormBtn = document.getElementById('show-filter-form-btn');
    const filterForm = document.getElementById('filterModal');

    if (showFilterFormBtn) {
        showFilterFormBtn.addEventListener('click', function () {
            // Open the modal when the button is clicked
            $(filterForm).modal('show');
        });
    }
    const saveFilterBtn = document.getElementById('save-filter-btn');

    if (saveFilterBtn) {
        saveFilterBtn.addEventListener('click', function () {
            document.getElementById('save-filter-form').submit();
        });
    }
});
        </script>



@endsection

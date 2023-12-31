@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Scrape product from URL</h2>

                    </div>

                    <div class="card-body">
                        <pre>
                            {{ print_r($data) }}
                        </pre>
                        <form class="form" action="{{ route('playground.store') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="mb-3">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="title" class="form-label">Product page URL</label>
                                <input type="text" name="url" class="form-control" placeholder="https://example.com/"
                                    @if (request()->get('url')) value="{{ request()->get('url') }}" >
                                @else
                                value="{{ old('url') }}" > @endif
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Title CSS Selector</label>
                                <input type="text" name="title" class="form-control" placeholder="h1.product-name"
                                    @if (request()->get('title')) value="{{ request()->get('title') }}" >
                                    @else  value="{{ old('title') }}" > @endif
                                    </div>

                                <div class="form-group">
                                    <label for="title" class="form-label">Description Selector</label>
                                    <input type="text" name="description" class="form-control"
                                        @if (request()->get('description')) value="{{ request()->get('description') }}" >
                                        @else  value="{{ old('description') }}" > @endif
                                        </div>

                                    <div class="form-group">
                                        <label for="title" class="form-label">Price CSS Selector</label>
                                        <input type="text" name="price" class="form-control"
                                            @if (request()->get('price')) value="{{ request()->get('price') }}" >
                                            @else  value="{{ old('price') }}" > @endif
                                            </div>

                                        <div class="form-group">
                                            <label for="title" class="form-label">Image CSS Selector</label>
                                            <input type="text" name="image" class="form-control"
                                                @if (request()->get('image')) value="{{ request()->get('image') }}" >
                                                @else  value="{{ old('image') }}" > @endif
                                                </div>


                                            <div class="form-group justify-content-end">
                                                <button type="submit" class="btn btn-primary btn-default">Grab
                                                    Product</button>
                                            </div>


                        </form>
                        <br><br><br>

                    </div>
                </div>
            </div>
        @endsection

        @push('css')
            <link href="assets/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
        @endpush

        @push('scripts')
            <script src="assets/plugins/data-tables/jquery.datatables.min.js"></script>
            <script src="assets/plugins/data-tables/datatables.bootstrap4.min.js"></script>
            <script>
                jQuery(document).ready(function() {
                    jQuery('#basic-data-table').DataTable({
                        "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
                    });
                });
            </script>
        @endpush

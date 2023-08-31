@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Product List </h2>
                    </div>

                    <div class="card-body">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    Products list
                                </div>
                                @if (count($products))

                                @foreach ($products as $item)
                                <div class="col-md-6 col-xl-3">
                                    <div class="card mb-4">
                                        <img class="card-img-top" src="assets/img/elements/cc1.jpg">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">{{ $item->name }}</h5>
                                            <p class="card-text pb-3">{{ str_limit($item->description , 100) }} </p>
                                            <a href="#" class="btn btn-outline-primary">{{ $item->price }}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                             
                         
                            </div>
                        </div>

                        
                            <table id="basic-data-table" class="table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                        <tr>
                                            <th scope="row"><a href="#"
                                                    class="fw-semibold">#{{ $item->id }}</a>
                                            </th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <h1>Products  not found</h1>
                            <br>
                           
                        @endif



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

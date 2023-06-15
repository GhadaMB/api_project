@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Products</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table table-striped table-bordered table-hover" data-paging="false" data-searching="false" data-info="false" id="table">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Product Image</th>
                            </tr>
                            </thead>
                            <tbody>
                                <td></td>
                                <td></td>
                                <td></td>
{{--                            @foreach (Auth::user()->products as $product)--}}
{{--                                <tr class="odd gradeX">--}}
{{--                                    <td>{{ $product->name }}</td>--}}
{{--                                    <td>{{ $product->description }}</td>--}}
{{--                                    <td>--}}
{{--                                        <img src="{{ asset('assets/products/'. $product->image) }}" width="70px" alt="Image here" >--}}
{{--                                    </td>--}}

{{--                                </tr>--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable( {
            "columnDefs": [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('getUserData') }}"
            },
            "columns":[

                { data: "name" },
                { data: "description" },
                { data: "image" }
            ]
        } );
    } );
</script>
@endsection

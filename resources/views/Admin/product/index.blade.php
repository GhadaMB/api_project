@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Products Page</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" data-paging="false" data-searching="false" data-info="false" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Assigned User</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
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
                    url: "{{ route('getData') }}"
                },
                "columns":[

                    { data: "id" },
                    { data: "name" },
                    { data: "description" },
                    { data: "image" },
                    { data: "user"},
                    { data: "action" }
                ]
            } );
        } );
    </script>
@endsection

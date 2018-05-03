@extends('layouts.layout')

@section('content')
    <table id="products-table" class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th> Наименование</th>
            <th> Стоимость</th>
        </tr>
        </thead>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            oTable = $('#products-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('datatable.getdata') }}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                ]
            });
        });
    </script>
@endsection
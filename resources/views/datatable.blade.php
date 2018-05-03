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
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#products-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('datatable.getdata') }}",
                "columns": [
                    // {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    // {data: 'created_at', name: 'created_at'},
                    // {data: 'updated_at', name: 'updated_at'},
                ],
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                }
            });
        });
    </script>
@endsection
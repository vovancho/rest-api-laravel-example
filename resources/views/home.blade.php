@extends('layouts.layout')

@section('content')
    <h1 class="mb-3"></h1>

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <th> Наименование</th>
        <th> Стоимость</th>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td> {{$product->name}} </td>
                <td> {{$product->price}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $products->links() }}

@endsection
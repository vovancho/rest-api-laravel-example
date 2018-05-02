@extends('layouts.layout')

@section('content')
    <h1 class="mb-3"></h1>

    <table class="table table-striped">
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td> {{$product->name}} </td>
                <td> {{$product->price}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
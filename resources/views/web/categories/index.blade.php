@extends('web.layouts.app')

@section('title', 'All Categories')

@section('content')
    <h2>Categories</h2>

    @if($categories->isEmpty())
        <p>No categories found.</p>
    @else
        <ul style="list-style: none; padding-left: 0;">
            @foreach($categories as $category)
                <li style="margin-bottom: 10px; font-size: 1.2rem;">
                    <a href="{{ route('web.categories.show', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection

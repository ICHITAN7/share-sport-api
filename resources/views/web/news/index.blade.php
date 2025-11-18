@extends('web.layouts.app')

@section('title', 'All News')

@section('content')
    <h2>All News</h2>

    <hr>

    @if($news->isEmpty())
        <p>No news articles found.</p>
    @else
        <div class="news-list">
            @foreach($news as $newsItem)
                <article style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                    <h3>
                        <a href="{{ route('web.news.show', $newsItem->slug) }}" style="text-decoration: none; color: #333;">
                            {{ $newsItem->title }}
                        </a>
                    </h3>
                    <p style="color: #666;">
                        Published on {{ $newsItem->published_at->format('M d, Y') }}
                    </p>
                    <p>{{ Str::limit($newsItem->content, 150) }}</p>
                    <a href="{{ route('web.news.show', $newsItem->slug) }}">Read more...</a>
                </article>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div style="margin-top: 20px;">
            {{ $news->links() }}
        </div>
    @endif
@endsection

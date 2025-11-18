@extends('web.layouts.app')

@section('title', $newsItem->title)

@section('content')

    <article class="news-full-article">
        <h2>{{ $newsItem->title }}</h2>

        <p style="color: #666; font-size: 0.9rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            Published on {{ $newsItem->published_at->format('F j, Y') }}
            @if($newsItem->category)
                in <a href="{{ route('web.categories.show', $newsItem->category->slug) }}">{{ $newsItem->category->name }}</a>
            @endif
        </p>

        <!-- Main Content -->
        <div class="article-content" style="line-height: 1.7; font-size: 1.1rem; white-space: pre-wrap; margin-top: 20px;">
            {{ $newsItem->content }}
        </div>
    </article>

    <hr style="margin-top: 30px; margin-bottom: 30px;">

    <!-- Related News Section -->
    @if(isset($relatedNews) && $relatedNews->isNotEmpty())
        <h3>Related News</h3>
        <div class="related-news-list">
            @foreach($relatedNews as $relatedItem)
                <article style="margin-bottom: 10px;">
                    <h4>
                        <a href="{{ route('web.news.show', $relatedItem->slug) }}" style="text-decoration: none; color: #333;">
                            {{ $relatedItem->title }}
                        </a>
                    </h4>
                    <p style="color: #666; font-size: 0.9rem;">
                        Published on {{ $relatedItem->published_at->format('M d, Y') }}
                    </p>
                </article>
            @endforeach
        </div>
    @endif

@endsection

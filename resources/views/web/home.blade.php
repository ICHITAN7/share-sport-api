@extends('web.layouts.app')

@section('title', 'Welcome to My News Site')

@section('content')

    <!-- Highlights Section -->
    @if(isset($highlights) && $highlights->isNotEmpty())
        <div class="highlights-section" style="margin-bottom: 30px; background: #f0f0f0; padding: 20px; border-radius: 8px;">
            <h2>Highlights</h2>
            @foreach($highlights as $highlight)
                <article style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                    <h3>{{ $highlight->title }}</h3>
                    <p>{{ $highlight->content }}</p>
                </article>
            @endforeach
        </div>
    @endif

    <!-- Recent News Section -->
    <h2>Recent News</h2>

    @if(isset($recentNews) && $recentNews->isNotEmpty())
        <div class="news-list">
            @foreach($recentNews as $newsItem)
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
    @else
        <p>No recent news to display.</p>
    @endif

@endsection

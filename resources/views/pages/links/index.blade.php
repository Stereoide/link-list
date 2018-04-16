@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $links->count() }} / {{ $linksNum }} Links</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group">
                    @foreach ($links as $link)
                        <li class="list-group-item link @if ($link->isStarred()) starred @endif">
                        @if (!empty($link->title))
                            {{ $link->title }}<br />
                        @endif
                            <a href="{{ route('links.follow', $link->id) }}" target="_blank">{{ $link->url }}</a><br />
                            <div class="links">
                            @if ($link->isStarred())
                                <a href="{{ route('links.unstar', $link->id) }}" class="text-dark">remove star</a>
                            @else
                                <a href="{{ route('links.star', $link->id) }}" class="text-dark">star</a>
                            @endif

                                <a href="{{ route('links.dismiss', $link->id) }}" class="text-dark">dismiss</a>
                            </div>
                            <div class="timestamps text-secondary">
                                <ul>
                                    <li>
                                        {{ $link->created_at->format('d.m.Y') }}
                                    </li>
                                    <li>
                                        @if ($link->isRead())
                                            Read at {{ $link->read_at->format('d.m.Y') }}@if ($link->isDismissed()), @endif
                                        @else
                                            not yet read
                                        @endif
                                    </li>
                                    <li>
                                        @if ($link->isDismissed())
                                            Dismissed at {{ $link->dismissed_at->format('d.m.Y') }}
                                        @else
                                            not yet dismissed
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

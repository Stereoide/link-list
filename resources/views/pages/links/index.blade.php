@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Links</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group">
                    @foreach ($links as $link)
                        <li class="list-group-item">
                        @if (!empty($link->title))
                            {{ $link->title }}<br />
                        @endif
                            <a href="{{ route('links.follow', $link->id) }}" target="_blank">{{ $link->url }}</a><br />
                        @if ($link->isRead())
                            Read at {{ $link->read_at->format('d.m.Y H:i') }}@if ($link->isDismissed()), @endif
                        @endif
                        @if ($link->isDismissed())
                            Dismissed at {{ $link->dismissed_at->format('d.m.Y H:i') }}
                        @else
                            <a href="{{ route('links.dismiss', $link->id) }}">dismiss</a>
                        @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

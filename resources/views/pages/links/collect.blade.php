@extends('layouts.app')

@section('content')
<form method="post" action="{{ route('processCollectedLinks') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Collect links</div>

                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                    <div class="form-group">
                        <label for="links">Links</label>
                        <textarea class="form-control" id="links" name="links" rows="25"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</form>
@endsection

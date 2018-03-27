@extends('layouts.app')

@section('content')
<form method="post" action="{{ route('processCollectedLinks') }}">
@csrf

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
                        <label for="urls">Links</label>
                        <textarea class="form-control" id="urls" name="urls" rows="25"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Collect" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</form>
@endsection

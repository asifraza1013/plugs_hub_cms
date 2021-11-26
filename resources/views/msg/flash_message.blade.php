<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p>{{ $message }}</p>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
        <button type="button" class="close" data-dismiss="alert">×</button>
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
</div>

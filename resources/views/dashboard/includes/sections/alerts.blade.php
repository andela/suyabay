@if (count($errors) > 0)
    @foreach($errors->all() as $error)
    <div class="row">
        <div class="error-message">
        {{ $error}}
        </div>
    </div>
    @endforeach
@endif

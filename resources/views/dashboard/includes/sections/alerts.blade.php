@if (count($errors) > 0)
    @foreach($errors->all() as $error)
    <div class="row">
        <div class="error-message">
        {{ $error }}
        </div>
    </div>
    @endforeach
@elseif ( session()->has('status'))
    <div class="row">
        <div class="success-message">
        {{ session()->get('status')}}
        </div>
    </div>
@endif

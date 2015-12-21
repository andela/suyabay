<div class="row">
    <div class="col s12">
    <p>
        <h3>A new Episode has been created awaiting your approval.</h3>
        <ul>
            <li><b>Created by:</b> {{ Auth::user()->username }} </li>
            <li><b>Date:</b> {{ date('Y-m-d H:i:s') }} </li>
            <li><b>Title:</b> {{ $title }} </li>
            <li><b>Description:</b> {{ $description}} </li>
            <li><b>Channel:</b> {{ $channel }} </li>
        </ul>
    </p>
    <p>
        <a href="{{ url('dashboard') }}" class="btn-large">
            Login To Moderate
        </a>
    </p>
    </div>
</div>

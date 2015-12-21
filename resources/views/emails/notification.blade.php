<div class="row">
    <div class="col s12">
        <h4>NEW EPISODE NOTIFICATION</h4>
    </div>
    <div class="col s12">
    <p>
        <h3>A new Episode has been created awaiting your approval.</h3>
        <ul>
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

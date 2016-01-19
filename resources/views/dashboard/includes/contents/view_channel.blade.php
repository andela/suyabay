<div class="col s12 m9">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large teal" href="{{ route('channel-create') }}" title="Create new channel">
            <i class="material-icons">add</i>
        </a>
    </div>
    <div class="row">
        <table class="bordered">
            <thead>
                <tr>
                    <th data-field="id">{!! $channel->channel_name !!}
                        <div class="count">{{ count($channel->episode) }} episodes</div>
                        <div class="right">
                            <a href="">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($episodes as $episode)
                <tr>
                    <td>{{ $episode->episode_name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

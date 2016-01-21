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
                        <div class="count-active">{{ count($channel->episode) }} episodes</div>
                        <div class="right">
                            <form action="{{ route('delete.channel', $channel->id )}}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="submit" value ="Delete"/>
                                    </div>
                                </div>
                            </form>
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

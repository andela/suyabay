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
                        @if(count($episodes) === 0)
                            <a href="#" id="delete_channel" data-token="{{ csrf_token() }}" data-id="{{ $channel->id }}" data-name="{{ $channel->title }}">
                                <i class="fa fa-trash-o"></i>
                                JUST DELETE
                            </a>
                        @else
                            <a href="#" id="swap_episode_delete_channel" data-token="{{ csrf_token() }}" data-id="{{ $channel->id }}" data-name="{{ $channel->title }}" data-episodes="{{ count($episodes) }}">
                                <i class="fa fa-trash-o"></i>
                                SWAP AND DELETE
                            </a>
                        @endif
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

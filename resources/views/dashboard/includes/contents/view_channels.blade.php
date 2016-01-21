<div class="col s12 m9">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large teal" href="{{ route('channel-create') }}" title="Create new channel">
            <i class="material-icons">add</i>
        </a>
    </div>
    <div class="row">
    @if(count($channels) === 0)
        <p>no channels at this time. check back!</p>
    @else
        <table class="highlight centered">
            <thead>
              <tr>
                  <th>TITLE</th>
                  <th>STATUS</th>
                  <th>EPISODES COUNT</th>
                  <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($channels as $channel)
            @if($channel->deleted_at)
            <tr>
                <td class="data-grid">
                    <p class="capitalize text-disabled">
                        <b>{{ $channel->channel_name }}</b>
                    </a>
                </td>
                <td class="data-grid">deleted</td>
                <td class="data-grid"> 
                    <div class="count-deleted">{{ count($channel->episode) }}</div>
                </td>
                <td clss="data-grid">
                    <div class="col s12 m6">
                        <form action="{{ route('restore.channel', $channel->id )}}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="submit" value ="undo"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @else
            <tr>
                <td class="data-grid">
                    <a href="/dashboard/channel/{{ $channel->id }}" class="capitalize" title="Created by {{ $channel->user->username }}">
                        <b>{{ $channel->channel_name }}</b>
                    </a>
                </td>
                <td class="data-grid">active</td>
                <td class="data-grid"> 
                    <div class="count-active">{{ count($channel->episode) }}</div>
                </td>
                <td clss="data-grid">
                    <div class="col s12 m6 red accent-2">
                        <a href="/dashboard/channel/{{ $channel->id }}/edit" class="pin" title="Edit this episode">
                            <i class="fa fa-edit"></i> 
                                Edit
                        </a>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>   
    @endif
    </div>
    <div class="row">{!! $channels->render() !!}</div>
</div>

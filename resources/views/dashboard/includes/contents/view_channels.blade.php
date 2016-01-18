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
            <thead class="teal lighten-2">
              <tr>
                  <th>Title</th>
                  <th>Created At</th>
                  <th>Episodes</th>
                  <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($channels as $channel)
            <tr>
                <td class="data-grid">
                    <a href="/dashboard/channel/{{ $channel->id }}" class="capitalize" title="{{ $channel->channel_description }}">
                        <b>{{ $channel->channel_name }}</b>
                    </a>
                </td>
                <td class="data-grid">{{ date('F d, Y', strtotime($channel->created_at)) }}</td>
                <td class="data-grid"> 
                    <div class="count">{{ count($channel->episode) }}</div>
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
            @endforeach
            </tbody>
        </table>   
    @endif
    </div>
</div>

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
                  <th data-field="id">Title</th>
                  <th data-field="name">Created By</th>
                  <th data-field="name">Created At</th>
                  <th data-field="price">Episodes</th>
                  <th data-field="price"></th>
              </tr>
            </thead>
            <tbody>
            @foreach($channels as $channel)
            <tr>
                <td>
                    <a href="/dashboard/channel/{{ $channel->id }}" class="capitalize" title="{{ $channel->channel_description }}">
                        <b>{{ $channel->channel_name }}</b>
                    </a>
                </td>
                <td>{{ $channel->user->username }}</td>
                <td>{{ date('F d, Y', strtotime($channel->created_at)) }}</td>
                <td> 
                    <div class="count">{{ count($channel->episode) }}</div>
                </td>
                <td>
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

<div class="row">

<!-- Side Nav -->
    @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        <table class="highlight centered">
            <thead class="teal lighten-2">
              <tr>
                  <th>Title</th>
                  <th>Created At</th>
                  <th>Episodes</th>
              </tr>
            </thead>
    @forelse($channels as $channel)
            <tbody>
            <tr>
                <td class="data-grid">
                    <a href="/channel/{{ $channel->id }}" class="capitalize" title="{{ $channel->channel_description }}">
                        <b>{{ $channel->channel_name }}</b>
                    </a>
                </td>
                <td class="data-grid">{{ date('F d, Y', strtotime($channel->created_at)) }}</td>
                <td class="data-grid"> 
                    <div class="count">{{ count($channel->episode) }}</div>
                </td>
            </tr>

    @empty

    sdfsfs

    @endforelse
            </tbody>
        </table>   

    </div>
</div>
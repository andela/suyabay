<div class="col s12 m9">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large teal" href="{{ route('channel-create') }}" title="Create new channel">
            <i class="material-icons">add</i>
        </a>
    </div>
    <div class="row">
        @if(count($paginatedUpgradeRequest) === 0)
        <p>No Request available for display.</p>
        @else
        <table class="highlight centered white">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>User</th>
                    <th>Date Requested</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paginatedUpgradeRequest as $index => $request)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="data-grid">
                        <p class="capitalize text-disabled">
                            <b>{{ ucwords($request->user->username) }}</b>
                        </a>
                    </td>
                    <td>{{ Carbon\Carbon::createFromTimeStamp(strtotime($request->created_at))->diffForHumans() }}</td>
                    <td class="data-grid">
                        <div class="col s12 m6 teal">
                            <a href="/dashboard/user/{{ $request->user->id }}/edit" class="pin" title="Upgrade this user">
                                <i class="fa fa-edit"></i>
                                Upgrade
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="row">{!! $paginatedUpgradeRequest->render() !!}</div>
</div>
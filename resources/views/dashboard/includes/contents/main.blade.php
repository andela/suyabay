<div class="col s12 m9">

    <div class="row">

        <!--
        Top panel: containes recent and information about suyabay
        #########################################################

        # Total users
        # Online users
        #
        #
        -->

        <div>
            <div class="col s12 m4">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Users</p>
                        <h1>{{$data['user']['total']->count()}}</h1>
                    </span>
                </div>
            </div>

            <div class="col s12 m4 ">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Online</p>
                        <h1>{{$data['user']['online']}}</h1>
                    </span>
                </div>
            </div>

            <div class="col s12 m4 ">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Channels</p>
                        <h1>{{$data['channels']->count()}}</h1>
                    </span>
                </div>
            </div>

        </div>


        <!--
        Episode tab controller
        ######################

        # Tab controller
        # Recent Episode
        # Pending Episode
        # Active Episode
        -->
        <div class="row">

            <!--
            # Tab controller
            -->
            <div class="col s12">
                <h4>Episodes</h4>
                <ul class="tabs">
                    <li class="tab col s3"><a class = "active" href="#test1">Recent Episodes</a></li>
                    <li class="tab col s3"><a class="" href="#test2">Pending Episodes</a></li>
                    <li class="tab col s3"><a class="" href="#test3">Active Episodes</a></li>
                </ul>
            </div>

            <!--
            # Recent Episode
            -->

            <div id="test1" class="col s12 tab-container">
                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $data['episodes']['recent'] as $recent )
                        <tr>
                            <td>{{ $recent->episode_name }}</td>
                            <td>{{ $recent->episode_description }}</td>
                            <td>{{ $recent->created_at->diffForHumans() }}</td>
                            <td width="150px;">
                                <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                                <select class="browser-default episode_action" >
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option data-action="{{$recent->id}}" value="delete">Delete</option>
                                    @if( $recent->status != 1 )
                                        <option data-action="{{$recent->id}}" value="activate">Active</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <!--
            # Pending Episode
            -->
            <div id="test2" class="col s12 tab-container">
                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $data['episodes']['pending'] as $pending )
                        <tr>
                            <td>{{ $pending->episode_name }}</td>
                            <td>{{ $pending->episode_description }}</td>
                            <td>{{ $pending->created_at->diffForHumans() }}</td>
                            <td width="150px;">
                                <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                                <select class="browser-default episode_action" >
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option data-action="{{$pending->id}}" value="delete">Delete</option>
                                    <option data-action="{{$pending->id}}" value="activate">Active</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--
            # Active Episode
            -->
            <div id="test3" class="col s12 tab-container">
                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>

                    <tbody id="active_section">
                        @foreach( $data['episodes']['active'] as $active )
                        <tr>
                            <td>{{ $active->episode_name }}</td>
                            <td>{{ $active->episode_description }}</td>
                            <td>{{ $active->created_at->diffForHumans() }}</td>
                            <td width="150px;">
                                <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                                <select class="browser-default episode_action" >
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option data-action="{{$active->id}}" value="delete">Delete</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

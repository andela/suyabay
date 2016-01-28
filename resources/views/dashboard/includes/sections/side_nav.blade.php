<div class="col s3 nav-container">
    <div class="hide-on-small-only">
        <div class="collection" style="border-color: transparent; ">
            <ul class="collapsible" data-collapsible="accordion" style="border-color: transparent; ">

                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">store</i>
                        <a href="/dashboard" class="collection-item">Home<span class="badge"></span></a>
                    </div>
                </li>


                <!-- Episode -->
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">video_library</i>
                        <a href="#!" class="collection-item">Episodes<span class="badge"></span></a>
                    </div>
                    <div class="collapsible-body" style="border-color: transparent;">
                        <ul class="collapsible" data-collapsible="accordion" style="border-color: transparent; ">

                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">chat_bubble_outline</i>
                                    <a href="{{ URL::to('/dashboard/episode/create') }}" class="collection-item">Create<span class="badge"></span></a>
                                </div>
                            </li>

                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">visibility</i>
                                    <a href="{{ URL::to('/dashboard/episodes') }}" class="collection-item">View Episodes<span class="badge"></span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                @can ( 'super-admin', Auth::user()->role->name )
                <!-- Channels -->
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">dns</i>
                        <a href="#!" class="collection-item">Channels<span class="badge"></span></a>
                    </div>
                    <div class="collapsible-body" style="border-color: transparent;">
                        <ul class="collapsible" data-collapsible="accordion" style="border-color: transparent; ">

                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">chat_bubble_outline</i>
                                    <a href="/dashboard/channel/create" class="collection-item">Create<span class="badge"></span></a>
                                </div>
                            </li>
                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">done_all</i>
                                    <a href="/dashboard/channels/active" class="collection-item">Active Channels<span class="badge"></span></a>
                                </div>
                            </li>

                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">not_interested</i>
                                    <a href="/dashboard/channels/deleted" class="collection-item">Deleted Channels<span class="badge"></span></a>
                                </div>
                            </li>

                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">swap_vertical_circle</i>
                                    <a href="/dashboard/channels/all" class="collection-item">View All<span class="badge"></span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Account -->
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">supervisor_account</i>
                        <a href="#!" class="collection-item">Account<span class="badge"></span></a>
                    </div>
                    <div class="collapsible-body" style="border-color: transparent;">
                        <ul class="collapsible" data-collapsible="accordion" style="border-color: transparent; ">

                            <li>
                                <div class="collapsible-header">
                                    <i class="fa fa-users"></i>
                                    <a href="/dashboard/users" class="collection-item">Users<span class="badge"></span></a>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</div>

<ul id="slide-out" class="side-nav">
    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>

        <li>
            <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>
    </ul>
</ul>


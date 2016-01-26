<div class="col s12 m9">
    <div class="row">
        @include('dashboard.includes.sections.alerts')
        <h4>Create Episode</h4>
        <div class="row">
            <form id="create_episode" class="col s12" action="/dashboard/episode/create" method="POST"
                    enctype="multipart/form-data" files="true">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="Episode Title" type="text" name="title">
                        <label for="title">Episode Title</label>
                    </div>

                    <div class="input-field col s6">
                        <select name="channel">
                            @foreach($channels as $channel)
                                <option value="{{$channel->id}}" name="channel">{{$channel->channel_name}}
                                </option>
                            @endforeach
                        </select>
                        <label for="channel">Channel Name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="description" placeholder="Episode Description">
                        <label for="description">Description</label>
                    </div>
                </div>

                <div class="row">
                    <label for="cover" class="btn-flat">Upload Cover Image</label>
                    <input type="file" name="cover" accept="image/*">
                </div>

                <div class="row">
                    <label for="file" class="btn-flat">Upload Podcast</label>
                    <input type="file" name="podcast" accept="mp3, audio/*">
                </div>
                <input type="submit"  value ="create" class="btn-large" />
            </form>
        </div>
    </div>
</div>

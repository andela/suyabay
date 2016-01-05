<div class="col s12 m9">

    <div class="row">

        <h4>Edit Episode</h4><br>

        <div class="row">

            <form class="col s12" action="{{ route('episode.update', $episode->id )}}" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="input-field col s6">
                        <input value="{!! $episode->episode_name !!}" name="title" type="text">
                        <label for="title">Episode Title</label>
                    </div>

                    <div class="input-field col s6">
                        <input placeholder="Enter Channel Name" name="channel" type="text">
                        <label for="channel">Episode Channel Name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <textarea name="description" class="materialize-textarea">
                        {!! $episode->episode_description !!}
                    </textarea>
                    <label for="description">Episode Description</label>
                    </div>
                </div>
                <div class="row">
                    <label for="cover" class="btn-flat">Change Cover Image</label>
                    <input type="file" name="cover" />
                </div>

                <div class="row">
                    <label for="file" class="btn-flat">Change Podcast</label>
                    <input type="file" name="podcast" />
                </div>
                <input type="submit"  value ="update" class="btn-large" />
            </form>
        </div>
    </div>
</div>

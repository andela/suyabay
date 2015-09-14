@extends('app.master')

@section('title', 'About SuyaBay')

@section('content')

<div class="row">

<div class="col s3">
 @include('app.includes.sections.side_nav')
</div>
<div class="col s8">
  <h3>About page</h3>
    <p>Suyabay Podcasts is an aggregator of podcasts for suya lovers across the net.

        The purpose of this site is to help suya lovers find new podcasts and contents. I encourage you to subscribe to the individual podcasts feeds and support the content creators.<br>

        Feel free to send any question that you think has not been answered in our FAQ (Frequently Ask Questions) and other comments to: questions@SuyaBay.com
    </p>



</div>

<div class="col s1">
</div>

</div>
@endsection
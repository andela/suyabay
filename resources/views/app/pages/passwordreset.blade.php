@extends('app.authlayout')

@section('title', 'reset | SuyaBay')

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6 center-align">

        <div>
            <h2>Hollup, hollup!</h2>
            <small>You need a password reset, right?</small>
        </div>

        <div class="row">

            <form class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">turned_in_not</i>
                            <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row container">

                    <a class="waves-effect waves-light btn right">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection

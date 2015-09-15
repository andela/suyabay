<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12 white-text">
                <!-- <h5>TRENDING ON SUYABAY</h5> -->
                <table class="bordered white-text centered">
                    <thead>
                        <tr>
                            <th data-field="">
                                <i class="tiny material-icons">theaters</i> POPULAR EPISODES
                            </th>
                            <th data-field="">
                                <i class="tiny material-icons">visibility</i> WATCHING
                            </th>
                            <th data-field="">
                                <i class="tiny material-icons">forum</i> COMMENTS
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a class="white-text waves-effect" href=""><em>suya recipies</em></a></td>
                            <td><a class="white-text" href="">100</a></td>
                            <td><a class="white-text" href="">50</a></td>
                        </tr>
                        <tr>
                            <td><a class="white-text waves-effect" href=""><em>New packagists</em></a></td>
                            <td><a class="white-text" href="">0</a></td>
                            <td><a class="white-text" href="">0</a></td>
                        </tr>
                        <tr>
                            <td><a class="white-text waves-effect" href=""><em>Suya on vagrant yum yum</em></a></td>
                            <td><a class="white-text" href="">50+</a></td>
                            <td><a class="white-text" href="">100+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="title">Become a Premium User</h5>
                <br>

                <div class="row">
                    <div class="col 16 s6">
                        <a class="waves-effect waves-light btn pink">contact</a>
                    </div>
                    <div class="col 16 s6">
                        <a class="waves-effect waves-light btn red">feedback</a>
                        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                            <a class="btn-floating btn-large red">
                                <i class="large material-icons">mode_edit</i>
                            </a>
                            <ul>
                                <li>
                                    <a class="btn-floating red"><i class="material-icons">insert_chart</i></i></a>
                                </li>
                                <li>
                                    <a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a>
                                </li>
                                <li>
                                    <a class="btn-floating green"><i class="material-icons">publish</i></a>
                                </li>
                                <li>
                                    <a class="btn-floating blue"><i class="material-icons">attach_file</i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-copyright">
        <div class="col s12 collection" style="border:0px;">
            <p class="white-text red lighten-2 collection-item right waves-effect"> Copyright Andela © {{ Yearly::current_year() }}</p>
            <a class="white-text red lighten-2 collection-item left waves-effect valign" href="{{ URL::to('about') }}"><i class="tiny material-icons valign">info</i> About</a>
            <a class="white-text red lighten-2 collection-item left waves-effect" href="{{ URL::to('faqs') }}"><i class="tiny material-icons valign">live_help</i> FAQs</a>
            <a class="white-text red lighten-2 collection-item left waves-effect" href="{{ URL::to('privacypolicy') }}"><i class="tiny material-icons">work</i> Privacy Policy</a>
        </div>
    </div>
</footer>

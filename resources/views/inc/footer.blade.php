<footer class="section footer-classic context-dark bg-image">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-4 col-xl-5">
                <div class="pr-xl-4"><a class="brand"></a>
                    <p><span class="descriptionr">2019</span><span> </span><span>Major Project</span><span>. </span><span>A K M Naharul Hayat, Noyan Raquib, Gavir Virk, Oto Mraz, Dusan Pilka, Ian Luong</span></p>
                </div>
            </div>
            <div class="col-md-4 pb-4">
                <h5>Contacts</h5>
                <dl class="contact-list">
                    <dt>email:</dt>
                    <dd><a href="mailto:#">K1764014@kcl.ac.uk</a></dd>
                </dl>
                <dl class="contact-list">
                    <dt>phones:</dt>
                    <dd><a href="tel:#">+4407518850169</a> <span>or</span> <a href="tel:#">+4407518850169</a>
                    </dd>
                </dl>

            </div>
            <div class="col-md-4 col-xl-3">
                <h5>Links</h5>
                <ul class="nav-list">
                    <!-- If no user is logged in -->
                    @guest
                    <li><a href="/">Home</a></li>
                    <li><a href="/learn_more">Learn More</a></li>
                    @endguest
                    @auth
                    <!-- If user is student -->
                    @if(Auth::user()->role == "student")
                    <li><a href="/user_area/index">Dashboard</a></li>
                    @endif
                    <!-- If user is admin -->
                    @if(Auth::user()->role == "admin")
                    <li><a href="/staff_area/sessions/index">Sessions</a></li>
                    <li><a href="/staff_area/interests/index">Interest Choices</a></li>
                    <li><a href="/staff_area/feedback">Feedback</a></li>
                    @endif
                    <!-- If user is super-admin -->
                    @if(Auth::user()->role == "super_admin")
                    <li><a href="/staff_area/sessions/index">Sessions</a></li>
                    <li><a href="/staff_area/interests/index">Interest Choices</a></li>
                    <li><a href="/staff_area/feedback">Feedback</a></li>
                    <li><a href="/staff_area/admin">Admin Users</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</footer>
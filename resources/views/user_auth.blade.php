<!-- Authentication Modal -->
<div class="modal fade" id="userAuthModal" tabindex="-1" role="dialog" aria-labelledby="userAuthModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    User Authentication
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body">

                <ul class="nav nav-tabs nav-fill mb-4" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active"
                           data-toggle="tab"
                           href="#loginTab">
                            Sign In
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           data-toggle="tab"
                           href="#registerTab">
                            Sign Up
                        </a>
                    </li>

                </ul>

                <div class="tab-content">

                    <!-- Sign In -->

                    <div class="tab-pane fade show active" id="loginTab">

                        <form id="signinUser">

                            <div class="form-group">

                                <label>Phone or Email Address</label>

                                <input type="text"
                                       class="form-control signin_login"
                                       name="login"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Password</label>

                                <input type="password"
                                       class="form-control signin_password"
                                       name="password"
                                       required>

                            </div>

                            <div class="d-flex justify-content-between mb-3">

                                <div class="custom-control custom-checkbox">

                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="remember">

                                    <label class="custom-control-label"
                                           for="remember">
                                        Remember Me
                                    </label>

                                </div>

                                <a href="#">
                                    Forgot Password?
                                </a>

                            </div>

                            <button class="btn btn-primary btn-block"
                                    type="submit">

                                Sign In

                            </button>

                        </form>

                    </div>

                    <!-- Sign Up -->

                    <div class="tab-pane fade" id="registerTab">

                        <form id="signupUser">

                            <div class="form-group">

                                <label>Name</label>

                                <input type="text"
                                       class="form-control signup-name"
                                       name="name"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Phone</label>

                                <input type="text"
                                       class="form-control signup-phone"
                                       name="phone"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Email</label>

                                <input type="email"
                                       class="form-control signup-email"
                                       name="email">

                            </div>

                            <div class="form-group">

                                <label>Password</label>

                                <input type="password"
                                       class="form-control signup-password"
                                       name="password"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Confirm Password</label>

                                <input type="password"
                                       class="form-control signup-confirm-password"
                                       name="confirm_password"
                                       required>

                            </div>

                            <button class="btn btn-success btn-block"
                                    type="submit">

                                Sign Up

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
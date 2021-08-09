        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="bg-gray-100 border-0 card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-white mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" wire:submit.prevent="submit">
                                            <div class="form-group">
                                                <input type="email"
                                                    class="border-0 form-control form-control-user @error('form.email') is-invalid @enderror"
                                                    name="email" required wire:model="form.email"
                                                    placeholder="Enter Email Address...">
                                                @error('form.email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="border-0 form-control form-control-user @error('form.password')
                                                is-invalid @enderror" id="myInput" placeholder="Password"
                                                    name="password" required wire:model="form.password">
                                                @error('form.password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input onclick="myFunction()" type="checkbox"
                                                        class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label text-white"
                                                        for="customCheck">Show Password</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-dark btn-user btn-block">
                                                Login
                                            </button>
                                        </form>
                                        <hr style="border-color: white !important">

                                        <div class="text-center">
                                            <a class="small text-white" href="/register">Create an
                                                Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

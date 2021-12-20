@section('title', 'Register - My Finance')
<div class="container">
    <div class="bg-gray-100 border-0 card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row mobile">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="small-when-0 p-5">
                        <div class="text-center">
                            <h1 class="h4 text-white mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" wire:submit.prevent="submit">
                            <div class="form-group">
                                <input type="text"
                                    class="border-0 form-control form-control-user @error('form.name') is-invalid @enderror"
                                    id="exampleFirstName" placeholder="Username" name="name" wire:model="form.name"
                                    required autocomplete="name" autofocus>
                                @error('form.name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email"
                                    class="border-0 form-control form-control-user @error('form.email') is-invalid @enderror"
                                    name="email" required autocomplete="email" wire:model="form.email"
                                    placeholder="Email Address">
                                @error('form.email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row mobile small-when-0 ">
                                <div class="col-sm-6 mb-sm-0 p-0 pr-1 mb-3-when-small">
                                    <input type="password"
                                        class="border-0 form-control form-control-user @error('form.password') is-invalid @enderror"
                                        wire:model="form.password" id="myInput" name="password" required
                                        autocomplete="new-password" placeholder="Password">
                                    @error('form.password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 p-0 mb-3-when-small">
                                    <input type="password" class="border-0 form-control form-control-user"
                                        wire:model="form.password_confirmation" name="password_confirmation" required
                                        autocomplete="new-password" id="myInput2" placeholder="Repeat Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input onclick="myFunction()" type="checkbox" class="custom-control-input"
                                        id="customCheck">
                                    <label class="custom-control-label text-white" for="customCheck">Show
                                        Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark btn-user btn-block">
                                Register Account
                            </button>
                            <hr>
                            <a href="{{ route('google.login') }}" class="btn btn-google btn-user btn-block border-0">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                            {{-- <a href="#" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                            </a> --}}
                        </form>
                        <hr style="border-color: white !important">
                        <div class="text-center">
                            <a class="small text-white" href="{{ route('login') }}">Already have an account?
                                Login!</a><br>
                            <a class="text-white" href="{{ route('fileupload') }}">To File Upload</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

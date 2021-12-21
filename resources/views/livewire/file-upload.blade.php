@section('title', 'File Upload - SSIP')

<div class="mt-4 ml-5 mr-5">

    <div class="d-flex">
        {{-- this mean if user is not logged in --}}
        @guest
            <a href="{{ route('login') }}" name="login" class="btn btn-primary">
                Login
            </a>
        @endguest
        {{-- if user is logged in --}}
        @auth
            <button wire:click="logout"" name=" logout" class="btn btn-danger mr-2">
                Logout
            </button>
        @endauth
        {{-- if the user is admin then act like superuser --}}
        @if (@auth()->user()->email == 'admin@example.com')
            {{-- on the submit of the form wire submit prevent mean it will call the function uploadFile in FileUpload Class --}}
            <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                {{-- this wire model file will merge to the public variable $file in FileUpload class --}}
                <input type="file" class="" wire:model.defer="file" required
                    id="upload{{ $fileIteration }}">
                {{-- error message validation --}}
                @error('file') <span class="error">{{ $message }}</span> @enderror
                {{-- if image still upload on loading then this button will be remove --}}
                <button wire:loading.remove type="submit" class="btn btn-primary">
                    Add
                </button>
                {{-- if image still upload on loading then this button will show --}}
                <button wire:loading wire:target="file" class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </form>
        @endif
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Type</th>
                <th scope="col">Name</th>
                <th scope="col">Size (KB)</th>
                <th scope="col">Downloads</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            {{-- this is to loop every fileupload --}}
            @foreach ($fileuploads as $key => $fileupload)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $fileupload->type }}</td>
                    <td>{{ $fileupload->name }}</td>
                    <td>{{ $fileupload->size }}
                    </td>
                    <td>
                        {{-- on button click this will call the function downloadImage in FileUpload class with the id as param --}}
                        <button class="btn btn-primary" wire:click="downloadImage({{ $fileupload->id }})">
                            Download
                        </button>
                    </td>
                    <td>
                        <div class="d-flex">
                            {{-- super user here add '@' before variable so if the var doesnt exist it will return false --}}
                            @if (@auth()->user()->email == 'admin@example.com')
                                <form class="" wire:submit.prevent="updateFile({{ $fileupload->id }})">
                                    <input type="file" class="" wire:model.defer="fileUpdate" required>
                                    <button wire:loading.remove type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button wire:loading wire:target="fileUpdate" class="btn btn-primary" type="button"
                                        disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </form>
                                <div class="ml-5">
                                    <button wire:click="deleteFile({{ $fileupload->id }})" class="btn btn-danger"
                                        name="delete_file-status">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

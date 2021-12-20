@section('title', 'File Upload - SSIP')

<div class="mt-4 ml-5 mr-5">

    <div class="d-flex">
        @guest
            <a href="{{ route('login') }}" name="login" class="btn btn-primary">
                Login
            </a>
        @endguest
        @auth
            <button wire:click="logout"" name=" logout" class="btn btn-danger mr-2">
                Logout
            </button>
        @endauth
        @if (@auth()->user()->email == 'admin@example.com')
            <form wire:submit.prevent="uploadFile">
                <input type="file" class="" wire:model.defer="file" required
                    id="upload{{ $fileIteration }}">
                @error('file') <span class="error">{{ $message }}</span> @enderror
                <button type="submit" class="btn btn-primary">
                    Add
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
            @foreach ($fileuploads as $key => $fileupload)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $fileupload->type }}</td>
                    <td>{{ $fileupload->name }}</td>
                    <td>{{ $fileupload->size }}
                    </td>
                    <td>
                        <button class="btn btn-primary" wire:click="downloadImage({{ $fileupload->id }})">
                            Download
                        </button>
                    </td>
                    <td>
                        <div class="d-flex">
                            @if (@auth()->user()->email == 'admin@example.com')
                                <form class="" wire:submit.prevent="updateFile({{ $fileupload->id }})">
                                    <input type="file" class="" wire:model.defer="fileUpdate" required>
                                    <button type="submit" class="btn btn-primary">
                                        Update
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

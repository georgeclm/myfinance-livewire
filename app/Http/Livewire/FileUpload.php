<?php

namespace App\Http\Livewire;

use App\Models\Fileupload as ModelsFileupload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;
    // this is the public variable that can be used inside view and the class
    public $file;
    public $fileUpdate;
    public $fileIteration = 0;
    // the upload file function
    public function uploadFile()
    {
        // validate the file is not empty
        $this->validate([
            'file' => 'required'
        ]);
        // store the file to public folder
        $file =  $this->file->store('public');
        // to store the file to the database with fileuploads table
        ModelsFileupload::create([
            // for the table column fill the data
            'file_name' => $file,
            'type' => $this->file->extension(),
            'name' => $this->file->getClientOriginalName(),
            'size' => $this->file->getSize() / 1000,
        ]);
        // this to show success message in session
        $this->emit('success', 'File have been uploaded');
        // empty the file again
        $this->file = null;
        // this to make fileupload to null again
        $this->fileIteration++;
    }


    public function downloadImage($fileId)
    {
        // find the file in database based on id
        $file = ModelsFileupload::findOrFail($fileId);
        // download the file with the file name (first param file path, second param file name)
        return Storage::download($file->file_name, $file->name);
    }
    // function to update the file
    public function updateFile($fileId)
    {
        // validation here
        $this->validate([
            'fileUpdate' => 'required'
        ]);
        $updatedFile = ModelsFileupload::findOrFail($fileId);
        // this to delete the previous file from the storage
        File::delete('storage/' . substr($updatedFile->file_name, 7));
        // store new image to the database
        $file =  $this->fileUpdate->store('public');
        // update the file data on new file
        $updatedFile->update([
            'file_name' => $file,
            'type' => $this->fileUpdate->extension(),
            'name' => $this->fileUpdate->getClientOriginalName(),
            'size' => $this->fileUpdate->getSize() / 1000,
        ]);
        // success notification
        $this->emit('success', 'File have been updated');
        // empty the file
        $this->fileUpdate = null;
    }

    public function deleteFile($fileId)
    {
        // find the file to be deleted
        $file = ModelsFileupload::findOrFail($fileId);
        // delete the file from the storage
        File::delete('storage/' . substr($file->file_name, 7));
        // delete file from the database
        $file->delete();
        // to show success notification
        $this->emit('success', 'File have been deleted');
    }

    public function logout()
    {
        // to logout
        Auth::logout();
        return redirect(route('login'));
    }

    public function render()
    {
        // when render the file show the blade folder with all fileuploads data
        $fileuploads = ModelsFileupload::all();
        return view('livewire.file-upload', compact('fileuploads'));
    }
}

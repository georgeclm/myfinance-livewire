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
    public $file;
    public $fileUpdate;
    public $fileIteration = 0;

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required'
        ]);
        $file =  $this->file->store('public');
        ModelsFileupload::create([
            'file_name' => $file,
            'type' => $this->file->extension(),
            'name' => $this->file->getClientOriginalName(),
            'size' => $this->file->getSize() / 1000,
        ]);
        $this->emit('success', 'File have been uploaded');
        $this->file = null;
        $this->fileIteration++;
    }


    public function downloadImage($fileId)
    {
        $file = ModelsFileupload::findOrFail($fileId);
        return Storage::download($file->file_name, $file->name);
    }

    public function updateFile($fileId)
    {
        $this->validate([
            'fileUpdate' => 'required'
        ]);
        $file =  $this->fileUpdate->store('public');
        ModelsFileupload::findOrFail($fileId)->update([
            'file_name' => $file,
            'type' => $this->fileUpdate->extension(),
            'name' => $this->fileUpdate->getClientOriginalName(),
            'size' => $this->fileUpdate->getSize() / 1000,
        ]);
        $this->emit('success', 'File have been updated');
        $this->fileUpdate = null;
    }

    public function deleteFile($fileId)
    {
        $file = ModelsFileupload::findOrFail($fileId);
        File::delete('storage/' . substr($file->file_name, 7));
        $file->delete();
        $this->emit('success', 'File have been deleted');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function render()
    {
        $fileuploads = ModelsFileupload::all();
        return view('livewire.file-upload', compact('fileuploads'));
    }
}

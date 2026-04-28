<?php

namespace App\Livewire\Backend;

use App\Models\Media;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Medias extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $media;
    public $totalMedia;
    public $perPage = 12;
    public $selectedMedia = []; // Array to store selected media items
    public $select;
    public $openModal;
    public $search;

    public $editedMedia;
    public $alt;
    public $description;
    public $caption;

    public function mount()
    {
        // $this->openModal = $openModal;
        $this->loadMedia();
    }

    public function loadMore()
    {
        $this->editedMedia = NULL;
        $this->reset(['alt', 'description', 'caption']);
        $this->perPage += 24;
        $this->loadMedia();
    }

    public function toggleSelect($mediaId)
    {
        $this->editedMedia = NULL;
        $this->reset(['alt', 'description', 'caption']);

        if ($this->select === 'multiple') {
            // Toggle selection for multiple mode
            if (in_array($mediaId, $this->selectedMedia)) {
                $this->selectedMedia = array_diff($this->selectedMedia, [$mediaId]);
            } else {
                $this->selectedMedia[] = $mediaId;
            }
        } else {
            // Store single array for single mode
            $this->selectedMedia = [$mediaId];
        }
    }

    private function loadMedia()
    {
        // $this->media = Media::latest()->take($this->perPage)->get();
        $this->totalMedia = Media::count();
    }

    public function deleteMedia($id)
    {
        $this->editedMedia = NULL;
        $this->reset(['alt', 'description', 'caption']);
        $media = Media::where('id', $id)->first();

        if ( $media != NULL ) {

            $media->delete();
            $this->dispatch('media-updated');
            $this->dispatch('success', [ 'message' => 'Image Deleted.' ]);

            $path  = public_path('storage/').$media->file_name;

            if ( file_exists($path ) )  {
                @unlink($path);
            }
        }
        else {
            $this->dispatch('warning', [ 'message' => 'Image Not Found.' ]);
        }
    }

    public function closeModal()
    {
        $this->openModal = 'false';
        $this->editedMedia = NULL;
        $this->reset(['alt', 'description', 'caption']);
    }

    // edit
    public function editMedia($id)
    {
        $this->reset(['alt', 'description', 'caption']);

        $media = Media::where('id', $id)->first();

        if ( $media != NULL ) {


            $this->editedMedia = $media;
            $this->alt = $media->alt;
            $this->description = $media->description;
            $this->caption = $media->caption;

            $this->dispatch('go_to_media_body');

        }
        else {
            $this->dispatch('warning', [ 'message' => 'Image Not Found.' ]);
        }
    }

    public function editedMediaSubmit($id)
    {
        $media = Media::where('id', $id)->first();

        if ( $media != NULL ) {

            $media->alt = $this->alt;
            $media->description = $this->description;
            $media->caption = $this->caption;
            $media->save();

            $this->dispatch('success', [ 'message' => 'Updated.' ]);

        }
        else {
            $this->dispatch('warning', [ 'message' => 'Image Not Found.' ]);
        }
    }

    public function reloadMedia()
    {
        $this->editedMedia = NULL;
        $this->reset(['alt', 'description', 'caption']);
        $this->dispatch('media-updated');
    }

    #[On('media-updated')]
    public function render()
    {
        // $this->media = Media::latest()->take($this->perPage)->get();
        // $this->media = Media::latest()->paginate(4);
        
        return view('livewire.backend.medias', [
            'medias' => Media::where('file_original_name', 'like', '%'.$this->search.'%')->latest()->paginate($this->perPage),
        ]);
    }
}

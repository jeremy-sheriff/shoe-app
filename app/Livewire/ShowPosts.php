<?php

namespace App\Livewire;

use Livewire\Component;

class ShowPosts extends Component
{
    public $post;

    public function render()
    {
        return view('livewire.show-posts');
    }
}

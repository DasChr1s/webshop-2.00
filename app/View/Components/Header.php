<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $title;
    public $links;

    public function __construct($title = null, $links = [])
    {
        $this->title = $title;
        $this->links = $links;
    }

    public function render()
    {
        return view('components.header');
    }
}

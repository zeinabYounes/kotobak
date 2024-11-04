<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Title extends Component
{
    /**
     * Create a new component instance.
     * @param string $title_text
     * @return void
     */
    public  $titleText;
    public function __construct( $titleText="hello")
    {
      $this->titleText =  $titleText;

    }

    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\View\View|string
     */
    public function render(): View|Closure|string
    {
        return view('components.title');
    }
}

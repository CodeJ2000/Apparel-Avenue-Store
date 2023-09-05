<?php

namespace App\View\Components\partials;

use Illuminate\View\Component;

class SingleProduct extends Component
{
    public $id;
    public $images;
    public $category;
    public $name;
    public $price;
    public $stocks;

    public function __construct($id, $images, $category, $name, $price, $stocks)
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.partials.single-product');
    }
}
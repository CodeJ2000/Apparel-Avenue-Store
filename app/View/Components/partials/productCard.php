<?php

namespace App\View\Components\partials;

use Illuminate\View\Component;

// This class represents a Blade component named 'productCard'
class productCard extends Component
{
    // Public properties to hold the data for the product card
    public $name; // Product name
    public $description; // Product description
    public $price; // Product price
    public $category; // Product category
    public $image; // Product image
    public $url;
    /**
     * Create a new component instance.
     *
     * @param string $name Product name
     * @param string $description Product description
     * @param string $category Product category
     * @param string $price Product price
     * @param string $image Product image URL
     * @return void
     */

    public function __construct($name, $description, $category, $price, $image, $url)
    {
        // Initialize the component's public properties with the provided data
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->price = $price;
        $this->image = $image;
        $this->url = $url;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Return the view that represents the product-card component
        return view('components.partials.product-card');
    }
}
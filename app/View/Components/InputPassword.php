<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputPassword extends Component
{
    public string $name;
    public string $label;
    public string $placeholder;

    public function __construct(
        string $name = 'password',
        string $label = 'Password',
        string $placeholder = 'Password'
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.input-password');
    }
}

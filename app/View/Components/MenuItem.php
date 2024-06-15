<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $label, public string $iconPath,public string $routeName)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return function (array $data) {
            // Default class to add if no specific "text-color" class is set
            $defaultHoverClass = 'hover:text-blue';
            $defaultTextClass = 'text-white';
            // Get the existing class attribute, if any
            $existingClass = $this->attributes->get('class');

            // dd($existingClass);

            // Determine if a specific text color class is already set
            $hasHoverTextColor = preg_match('/\bhover:text-(red|blue|green|black)\b/', $existingClass);

            // $hasTextColor = preg_match('/\btext-(white|blue|green|black)\b/', $existingClass);

            if (!$hasHoverTextColor) {
                $newClass = trim($existingClass . ' ' . $defaultHoverClass);

                $this->attributes['class'] = $newClass;
            }

            // dd([
            //     'existing' => $existingClass,
            //     'hasHoverTextColor' => $hasHoverTextColor,
            //     'hasTextColor' => $hasTextColor,
            // ]);

            // if (!$hasTextColor) {
            //     $newClass = trim($existingClass . ' ' . $defaultHoverClass);

            //     $this->attributes['class'] = $newClass;

            //     dd($this->attributes);
            // }

            return view('components.menu-item', ['attributes' => $this->attributes]);
        };
    }
}

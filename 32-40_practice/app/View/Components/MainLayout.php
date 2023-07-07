<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\FreeCourse;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
		$slider = Course::orderByDesc('id')->get();
		$courses = FreeCourse::orderByDesc('id')->get();
		return view('layouts.main-layout', ['slider' => $slider, 'courses' => $courses]);
    }
}

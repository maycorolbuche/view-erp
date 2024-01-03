<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Chart extends Component
{
    public $id, $seriesName, $pointFormat;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $series = '[]',
        public string $type = 'pie',
        string $id = '',
        string $seriesName = '',
        string $pointFormat = '',
    ) {
        $this->id = $id ?: Str::random(8);
        $this->seriesName = $seriesName ?: 'Porcentagem';
        $this->pointFormat = $pointFormat ?: '{series.name}: <b>{point.percentage:.1f}%</b>';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chart');
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Survey as ModelsSurvey;
use Livewire\Component;

class Survey extends Component
{
    public $labels, $dataset;

    public function mount()
    {
        $this->labels = ['Sangat Memuaskan', 'Memuaskan', 'Cukup Memuaskan', 'Kurang Memuaskan'];
        $sm = ModelsSurvey::where('survey', 4)->count();
        $m = ModelsSurvey::where('survey', 3)->count();
        $cm = ModelsSurvey::where('survey', 2)->count();
        $km = ModelsSurvey::where('survey', 1)->count();
        $data = [$sm, $m, $cm, $km];
        $this->dataset = [
            [
                'label' => 'Responden',
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgba(15,64,97,255)'
                ],
                'borderColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgba(15,64,97,255)'
                ],
                'data' => $data,
                'offset' => 20
            ],
        ];
    }
    public function render()
    {
        $survey = ModelsSurvey::latest()->take(10)->get();
        return view('livewire.admin.survey', compact('survey'));
    }
}

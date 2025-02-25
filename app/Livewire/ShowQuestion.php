<?php

namespace App\Livewire;

use App\Models\Degree;
use Livewire\Component;
use App\Models\Question;

class ShowQuestion extends Component
{
    public $quizze_id, $student_id, $data, $counter = 0, $questioncount = 0;

    public function render()
    {
        $this->data = Question::where('quizze_id', $this->quizze_id)->get();
        // dd($this->data);
        $this->questioncount = $this->data->count();
        return view('livewire.show-question', ['data']);
    }

    public function nextQuestion($question_id, $score, $answer, $right_answer)
    {
        dd(auth('student')->user());
        
    }}
    
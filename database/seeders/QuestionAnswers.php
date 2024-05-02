<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionAnswers extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $questionTable = "questions";
    private $answerTable = "answers";

    public function run(): void
    {
        $questionAnswers = $this->getQuestionAnswers();
        $this->command->info( ' No of questions will be added => ' . count($questionAnswers));

        foreach ($questionAnswers as $questionAnswer) {
            $answers = [];
            $questionId = DB::table($this->questionTable)->insertGetId([
                "text" => $questionAnswer["question"]
            ]);

            if($questionId) {
                foreach ($questionAnswer["answers"] as $index => $answer) {
                    $answers[] = [
                        "question_id" => $questionId,
                        "text" => $answer,
                        "is_correct" => $index == $questionAnswer["correct"]
                    ];
                }
                DB::table($this->answerTable)->insert($answers);
            }
        }
    }

    private function getQuestionAnswers() {
        return [
            [
              "question" => "What is PHP?",
              "answers" => [
                  "PHP is an open-source programming language",
                  "PHP is used to develop dynamic and interactive websites",
                  "PHP is a server-side scripting language",
                  "All of the mentioned"
              ],
              "correct" => 3
            ], [
                "question" => "Who is the father of PHP?",
                "answers" => [
                    "Drek Kolkevi",
                    "Rasmus Lerdorf",
                    "Willam Makepiece",
                    "List Barely"
                ],
                "correct" => 1
            ],           [
                "question" => "What does PHP stand for?",
                "answers" => [
                    "PHP stands for Preprocessor Home Page",
                    "PHP stands for Pretext Hypertext Processor",
                    "PHP stands for Hypertext Preprocessor",
                    "PHP stands for Personal Hyper Processor"
                ],
                "correct" => 2
            ], [
                "question" => "Which of the following is the correct syntax to write a PHP code?",
                "answers" => [
                    "<?php ?>",
                    "< php >",
                    "< ? php ?>",
                    "<? ?>"
                ],
                "correct" => 3
            ],[
                "question" => "Which of the following is the correct way to add a comment in PHP code?",
                "answers" => [
                    "#",
                    "//",
                    "/* */",
                    "All of the mentioned"
                ],
                "correct" => 3
            ],[
                "question" => "Which of the following is the default file extension of PHP files?",
                "answers" => [
                    ".php",
                    ".ph",
                    ".xml",
                    ".html"

                ],
                "correct" => 0
            ],[
                "question" => "How to define a function in PHP?",
                "answers" => [
                    "functionName(parameters) {function body}",
                    "function {function body}",
                    "function functionName(parameters) {function body}",
                    "data type functionName(parameters) {function body}"
                ],
                "correct" => 2
            ], [
                "question" => "Which is the right way of declaring a variable in PHP?",
                "answers" => [
                    "$3hello",
                    '$_hello',
                    '$this',
                    '$5_Hello'
                ],
                "correct" => 1
            ], [
                "question" => "Which of the following PHP functions can be used for generating unique ids?",
                "answers" => [
                    "md5()",
                    "uniqueid()",
                    "mdid()",
                    "id()"
                ],
                "correct" => 1
            ]
        ];
    }
}

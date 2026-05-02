<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    protected $exam;
    protected $errors = [];
    protected $successCount = 0;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                // Convert row to array if it's an object
                $row = is_array($row) ? $row : $row->toArray();

                // Debug: Log the row data
                Log::info('Processing row: ', $row);

                // Validate required fields - using correct column names
                if (
                    empty($row['question']) || empty($row['option_a']) || empty($row['option_b']) ||
                    empty($row['option_c']) || empty($row['option_d']) || !isset($row['correct_option'])
                ) {
                    $this->errors[] = "Row " . ($index + 2) . ": Missing required fields. Please check question, option_a, option_b, option_c, option_d, correct_option";
                    continue;
                }

                // Get correct option index (1-4)
                $correctOption = (int) $row['correct_option'] - 1; // Convert to 0-based index
                if ($correctOption < 0 || $correctOption > 3) {
                    $this->errors[] = "Row " . ($index + 2) . ": Correct option must be between 1 and 4";
                    continue;
                }

                // Prepare options array
                $options = [
                    $row['option_a'],
                    $row['option_b'],
                    $row['option_c'],
                    $row['option_d']
                ];

                // Validate options are not empty
                if (empty(array_filter($options))) {
                    $this->errors[] = "Row " . ($index + 2) . ": All options must be filled";
                    continue;
                }

                // Create question
                $question = Question::create([
                    'exam_id' => $this->exam->id,
                    'question_text' => $row['question'],
                    'difficulty' => isset($row['difficulty']) ? $row['difficulty'] : 'medium',
                    'marks' => isset($row['marks']) ? (int)$row['marks'] : 1,
                    'negative_marks' => isset($row['negative_marks']) ? (int)$row['negative_marks'] : 0,
                    'explanation' => $row['explanation'] ?? null,
                    'type' => 'single',
                    'order' => $this->exam->questions()->count() + 1,
                ]);

                // Create options
                foreach ($options as $optIndex => $optionText) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct' => $optIndex == $correctOption,
                        'order' => $optIndex + 1,
                    ]);
                }

                $this->successCount++;
            }

            // Update exam total questions
            $this->exam->update([
                'total_questions' => $this->exam->questions()->count()
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk import error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|integer|min:1|max:4',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'marks' => 'nullable|integer|min:1',
            'negative_marks' => 'nullable|integer|min:0',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Row " . $failure->row() . ": " . implode(', ', $failure->errors());
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}

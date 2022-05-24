<?php

namespace App\Http\Requests\ToDoList;

use App\Http\Requests\BaseRequest;
use App\Models\TodoList\ToDoList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property-read string $title
 * @property-read string $description
 * @property-read string $priority
 * @property-read string $parent_id
 */
class StoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'priority'    => ['nullable', Rule::in(1, 2, 3, 4, 5)],
            'parent_id'   => ['nullable',
                              Rule::exists(\App\Models\TodoListList\TodoList::class, 'id')->where(function ($query) {
                                  return $query->whereUserId(Auth::user()->id)
                                      ->whereStatus(TodoList::STATUS_TODO);
                              }),
            ],
        ];
    }
}

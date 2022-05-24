<?php

namespace App\Http\Requests\ToDoList;

use App\Http\Requests\BaseRequest;
use App\Models\ToDoList\ToDoList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property-read string $title
 * @property-read string $priority
 * @property-read string $status
 * @property-read string $sort_by
 * @property-read string $direction
 */
class SearchRequest extends BaseRequest
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
            'title'     => ['nullable', 'string', 'max:255'],
            'priority'  => ['nullable', Rule::in(1, 2, 3, 4, 5)],
            'status'    => ['nullable', Rule::in(ToDoList::getStatuses())],
            'sort_by'   => ['nullable', Rule::in(ToDoList::getAvailableSortField())],
            'direction' => ['nullable', Rule::in('ASC', 'DESC'), 'required_with:sort_by'],
        ];
    }
}

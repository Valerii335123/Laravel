<?php

namespace App\Models\ToDoList\UseCase;

use App\Models\ToDoList\ToDoList;
use App\Repositories\ToDoList\ToDoListRepositoryInterface;
use Carbon\Carbon;


class Complete
{

    /**
     * @var \App\Repositories\TodoList\ToDoListRepositoryInterface|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected ToDoListRepositoryInterface $toDoListRepository;

    /**
     * @param \App\Models\ToDoList\ToDoList $toDoList
     */
    public function __construct(public ToDoList $toDoList)
    {
        $this->toDoListRepository = resolve(ToDoListRepositoryInterface::class);
    }

    /**
     * @return void
     */
    public function handler(): void
    {
        $this->toDoList->status      = TodoList::STATUS_DONE;
        $this->toDoList->complete_at = Carbon::now();

        $this->toDoListRepository->save($this->toDoList);
    }

}

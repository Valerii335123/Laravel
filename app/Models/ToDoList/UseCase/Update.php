<?php

namespace App\Models\ToDoList\UseCase;

use App\Models\ToDoList\ToDoList;
use App\Repositories\ToDoList\ToDoListRepositoryInterface;


class Update
{
    /**
     * @var \App\Repositories\TodoList\TodoListRepositoryInterface|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected ToDoListRepositoryInterface $toDoListRepository;

    /**
     * @param \App\Models\ToDoList\ToDoList $TodoList
     * @param string $title
     * @param string $description
     * @param int|null $priority
     */
    public function __construct(
        public ToDoList $toDoList,
        public string   $title,
        public string   $description,
        public ?int     $priority
    ) {
        $this->toDoListRepository = resolve(ToDoListRepositoryInterface::class);
    }

    /**
     * @return \App\Models\ToDoList\ToDoList
     */
    public function handler(): ToDoList
    {
        $this->toDoList->title       = $this->title;
        $this->toDoList->description = $this->description;
        $this->toDoList->setPriority($this->priority);

        $this->toDoListRepository->save($this->toDoList);

        return $this->toDoList;
    }

}

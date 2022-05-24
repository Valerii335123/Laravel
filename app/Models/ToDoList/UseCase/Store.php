<?php

namespace App\Models\ToDoList\UseCase;

use App\Models\ToDoList\ToDoList;
use App\Models\User;
use App\Repositories\ToDoList\ToDoListRepositoryInterface;

class Store
{
    /**
     * @var \App\Repositories\TodoList\TodoListRepositoryInterface|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected ToDoListRepositoryInterface $toDoListRepository;

    /**
     * @param \App\Models\User $user
     * @param string $title
     * @param string $description
     * @param int|null $priority
     * @param int|null $parentId
     */
    public function __construct(
        public User   $user,
        public string $title,
        public string $description,
        public ?int   $priority,
        public ?int   $parentId
    ) {
        $this->toDoListRepository = resolve(ToDoListRepositoryInterface::class);
    }

    /**
     * @return \App\Models\ToDoList\ToDoList
     */
    public function handler(): ToDoList
    {
        $toDoList = new ToDoList();

        $toDoList->title       = $this->title;
        $toDoList->description = $this->description;
        $toDoList->setPriority($this->priority);

        if (!empty($this->parentId)) {
            $parentTodoList = $this->toDoListRepository->findById($this->parentId);
            $toDoList->parent()->associate($parentTodoList);
        }

        $toDoList->status  = ToDoList::STATUS_TODO;
        $toDoList->user_id = $this->user->id;

        $this->toDoListRepository->save($toDoList);
        return $toDoList;
    }

}

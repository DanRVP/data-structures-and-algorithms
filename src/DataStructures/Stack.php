<?php

declare(strict_types=1);

namespace Dsa\DataStructures;

class Stack
{
    /**
     * Pointer for key which represents top of the stack
     *
     * @var integer
     */
    private int $top = -1;

    /**
     * Unbounded array which holds that data items
     *
     * @var array
     */
    private array $stack = [];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->stack = $data;
        $count = count($data);
        if ($count > 0) {
            $this->top = $count - 1;
        }
    }

    /**
     * Adds an item to the stack
     *
     * @return void
     */
    public function push(mixed $item)
    {
        $this->top++;
        $this->stack[$this->top] = $item;
    }

    /**
     * Returns the top item in the stack and unsets it
     *
     * @return mixed
     */
    public function pop(): mixed
    {
        if ($this->isEmpty()) {
            return null;
        }

        $item = $this->stack[$this->top];
        unset($this->stack[$this->top]);
        $this->top--;
        return $item;
    }

    /**
     * Check if the stack is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->top === -1;
    }

    /**
     * Get the top item in the stack without removing it
     *
     * @return mixed
     */
    public function peek(): mixed
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->stack[$this->top];
    }
}

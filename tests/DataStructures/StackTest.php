<?php

declare(strict_types=1);

namespace DsaTests\DataStructures;

use Dsa\DataStructures\Stack;
use DsaTests\PrivateClassReflectionTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    use PrivateClassReflectionTrait;

    /**
     * Tests pushing items to the stack
     *
     * @param array $items
     * @param int $expected_top
     */
    #[DataProvider('pushProvider')]
    public function testPush(array $items, int $expected_top): void
    {
        $stack = new Stack();
        foreach ($items as $item) {
            $stack->push($item);
        }

        $top = $this->getPrivateProperty($stack, 'top');
        $stack = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($items, $stack);
        $this->assertIsInt($top);
        $this->assertEquals($expected_top, $top);
    }

    /**
     * Provider for test data for testPush()
     *
     * @return array
     */
    public static function pushProvider(): array
    {
        $set_1 = [
            'items' => [1, 2, 3, 4, 5],
            'expected_top' => 4,
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'expected_top' => 2,
        ];

        return compact('set_1', 'set_2');
    }

    /**
     * Tests popping items from the stack
     *
     * @param array $items
     * @param mixed $expected_item
     * @param integer $expected_top
     * @param array $expected_stack
     * @return void
     */
    #[DataProvider('popProvider')]
    public function testPop(array $items, mixed $expected_item, int $expected_top, array $expected_stack): void
    {
        $stack = new Stack($items);

        $popped = $stack->pop();
        $top = $this->getPrivateProperty($stack, 'top');
        $stack = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($expected_item, $popped);
        $this->assertIsInt($top);
        $this->assertEquals($expected_top, $top);
        $this->assertEquals($expected_stack, $stack);
    }

    /**
     * Provider for test data for testPush()
     *
     * @return array
     */
    public static function popProvider(): array
    {
        $set_1 = [
            'items' => [1, 2, 3, 4, 5],
            'expected_item' => 5,
            'expected_top' => 3,
            'expected_stack'  => [1, 2, 3, 4],
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'expected_item' => 'z',
            'expected_top' => 1,
            'expected_stack'  => ['x', 'y'],
        ];

        $empty = [
            'items' => [],
            'expected_item' => null,
            'expected_top' => -1,
            'expected_stack'  => [],
        ];

        return compact('set_1', 'set_2', 'empty');
    }

    /**
     * Tests peeking items from the stack
     *
     * @param array $items
     * @param mixed $expected_item
     * @param int $expected_top
     */
    #[DataProvider('peekProvider')]
    public function testPeek(array $items, mixed $expected_item, int $expected_top): void
    {
        $stack = new Stack($items);

        $peeked = $stack->peek();
        $top = $this->getPrivateProperty($stack, 'top');
        $stack = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($expected_item, $peeked);
        $this->assertIsInt($top);
        $this->assertEquals($expected_top, $top);
        $this->assertEquals($items, $stack);
    }

    /**
     * Provider for test data for testPush()
     *
     * @return array
     */
    public static function peekProvider(): array
    {
        $set_1 = [
            'items' => [1, 2, 3, 4, 5],
            'expected_item' => 5,
            'expected_top' => 4,
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'expected_item' => 'z',
            'expected_top' => 2,
        ];

        $empty = [
            'items' => [],
            'expected_item' => null,
            'expected_top' => -1,
        ];

        return compact('set_1', 'set_2', 'empty');
    }

    /**
     * Tests for checking if stack is empty
     *
     * @param array $items
     * @param bool $expected
     */
    #[DataProvider('isEmptyProvider')]
    public function testIsEmpty(array $items, bool $expected): void
    {
        $stack = new Stack($items);
        $this->assertEquals($expected, $stack->isEmpty());
    }

    /**
     * Provider for test data for testPush()
     *
     * @return array
     */
    public static function isEmptyProvider(): array
    {
        $set_1 = [
            'items' => [1, 2, 3, 4, 5],
            'expected' => false,
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'expected' => false,
        ];

        $empty = [
            'items' => [],
            'expected' => true,
        ];

        return compact('set_1', 'set_2', 'empty');
    }
}

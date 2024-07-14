<?php

declare(strict_types=1);

namespace DsaTests\DataStructures;

use Dsa\DataStructures\FixedSizeStack;
use Dsa\DataStructures\Stack;
use DsaTests\PrivateClassReflectionTrait;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SplFixedArray;

class FixedSizeStackTest extends TestCase
{
    use PrivateClassReflectionTrait;

    /**
     * Tests pushing items to the stack
     *
     * @param array $items
     * @param int $expected_top
     */
    #[DataProvider('pushProvider')]
    public function testPush(
        array $items,
        int $size,
        int $expected_top,
        null|Exception $expected_exception,
        SplFixedArray $expected_stack,
    ): void {
        $stack = new FixedSizeStack($size);
        foreach ($items as $item) {
            try {
                $stack->push($item);
            } catch (Exception $e) {
                $this->assertEquals($expected_exception, $e);
            }
        }

        $top = $this->getPrivateProperty($stack, 'top');
        $stack = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($expected_stack, $stack);
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
            'size' => 5,
            'expected_top' => 4,
            'expected_exception' => null,
            'expected_stack' => (new SplFixedArray(5))->fromArray([1, 2, 3, 4, 5])
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'size' => 3,
            'expected_top' => 2,
            'expected_exception' => null,
            'expected_stack' => (new SplFixedArray(3))->fromArray(['x', 'y', 'z'])
        ];

        $error = [
            'items' => ['x', 'y', 'z'],
            'size' => 2,
            'expected_top' => 1,
            'expected_exception' => new Exception('The stack is full. You cannot add any more items.'),
            'expected_stack' => (new SplFixedArray(2))->fromArray(['x', 'y'])
        ];

        return compact('set_1', 'set_2', 'error');
    }

    /**
     * Tests popping items from the stack
     *
     * @param array $items
     * @param mixed $expected_item
     * @param integer $expected_top
     * @param SplFixedArray $expected_stack
     * @return void
     */
    #[DataProvider('popProvider')]
    public function testPop(
        array $items,
        int $size,
        mixed $expected_item,
        int $expected_top,
        SplFixedArray $expected_stack
    ): void {
        $stack = new FixedSizeStack($size);
        foreach ($items as $item) {
            $stack->push($item);
        }

        $popped = $stack->pop();
        $top = $this->getPrivateProperty($stack, 'top');
        $data = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($expected_item, $popped);
        $this->assertIsInt($top);
        $this->assertEquals($expected_top, $top);
        $this->assertEquals($expected_stack, $data);
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
            'size' => 5,
            'expected_item' => 5,
            'expected_top' => 3,
            'expected_stack' => (new SplFixedArray(3))->fromArray([1, 2, 3, 4, null]),
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'size' => 3,
            'expected_item' => 'z',
            'expected_top' => 1,
            'expected_stack' => (new SplFixedArray(3))->fromArray(['x', 'y', null]),
        ];

        $empty = [
            'items' => [],
            'size' => 5,
            'expected_item' => null,
            'expected_top' => -1,
            'expected_stack' => new SplFixedArray(5),
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
    public function testPeek(
        array $items,
        int $size,
        mixed $expected_item,
        int $expected_top,
        SplFixedArray $expected_stack
    ): void {
        $stack = new FixedSizeStack($size);
        foreach ($items as $item) {
            $stack->push($item);
        }

        $peeked = $stack->peek();
        $top = $this->getPrivateProperty($stack, 'top');
        $data = $this->getPrivateProperty($stack, 'stack');

        $this->assertEquals($expected_item, $peeked);
        $this->assertIsInt($top);
        $this->assertEquals($expected_top, $top);
        $this->assertEquals($expected_stack, $data);
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
            'size' => 5,
            'expected_item' => 5,
            'expected_top' => 4,
            'expected_stack' => (new SplFixedArray(5))->fromArray([1, 2, 3, 4, 5]),
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'size' => 3,
            'expected_item' => 'z',
            'expected_top' => 2,
            'expected_stack' => (new SplFixedArray(3))->fromArray(['x', 'y', 'z']),
        ];

        $empty = [
            'items' => [],
            'size' => 3,
            'expected_item' => null,
            'expected_top' => -1,
            'expected_stack' => new SplFixedArray(3),
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
    public function testIsEmpty(array $items, int $size, bool $expected): void
    {
        $stack = new FixedSizeStack($size);
        foreach ($items as $item) {
            $stack->push($item);
        }

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
            'size' => 5,
            'expected' => false,
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'size' => 3,
            'expected' => false,
        ];

        $empty = [
            'items' => [],
            'size' => 3,
            'expected' => true,
        ];

        return compact('set_1', 'set_2', 'empty');
    }

    /**
     * Tests for checking if stack is full
     *
     * @param array $items
     * @param bool $expected
     */
    #[DataProvider('isFullProvider')]
    public function testIsFull(array $items, int $size, bool $expected): void
    {
        $stack = new FixedSizeStack($size);
        foreach ($items as $item) {
            $stack->push($item);
        }

        $this->assertEquals($expected, $stack->isFull());
    }

    /**
     * Provider for test data for testIsFull()
     *
     * @return array
     */
    public static function isFullProvider(): array
    {
        $set_1 = [
            'items' => [1, 2, 3],
            'size' => 5,
            'expected' => false,
        ];

        $set_2 = [
            'items' => ['x', 'y', 'z'],
            'size' => 3,
            'expected' => true,
        ];

        $empty = [
            'items' => [],
            'size' => 3,
            'expected' => false,
        ];

        return compact('set_1', 'set_2', 'empty');
    }
}

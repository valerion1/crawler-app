<?php declare( strict_types = 1 );

namespace Tests;

use App\Helpers\Collection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class CollectionTest
 * @package Tests
 */
class CollectionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreate () : void
    {
        $collection = new Collection(['one', 'two', 'three']);
        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($collection));
        self::assertEquals($items->getValue($collection), ['one', 'two', 'three']);
    }

    /**
     * @return void
     */
    public function testPush () : void
    {
        $collection = new Collection(['one', 'two', 'three']);
        $collection->push('four');

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($collection));
        self::assertEquals($items->getValue($collection), ['one', 'two', 'three', 'four']);
    }

    /**
     * @return void
     */
    public function testAppend () : void
    {
        $collection = new Collection(['one', 'two', 'three']);
        $collection->append(['four', 'five']);

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($collection));
        self::assertEquals($items->getValue($collection), ['one', 'two', 'three', 'four', 'five']);
    }

    /**
     * @return void
     */
    public function testMap () : void
    {
        $collection       = new Collection([1, 2, 3]);
        $mappedCollection = $collection->map(function(int $item) {
            return $item * 2;
        });

        self::assertNotEquals($mappedCollection, $collection);

        $reflection = new ReflectionClass($mappedCollection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($mappedCollection));
        self::assertEquals($items->getValue($mappedCollection), [2, 4, 6]);
    }

    /**
     * @return void
     */
    public function testEach () : void
    {
        $collection = new Collection([1, 2, 3]);

        $itemsFromEach = [];
        $collection->each(function(int $item) use(&$itemsFromEach) {
            $itemsFromEach[] = $item;
        });

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertEquals($itemsFromEach, $items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testImplode () : void
    {
        $collection    = new Collection([1, 2, 3]);
        $implodeResult = $collection->implode('|');

        self::assertEquals($implodeResult, '1|2|3');
        self::assertNotEquals($implodeResult, '1 2 3');
        self::assertNotEquals($implodeResult, '123');

        $defaultImplodeResult = $collection->implode();

        self::assertNotEquals($defaultImplodeResult, '1|2|3');
        self::assertNotEquals($defaultImplodeResult, '1 2 3');
        self::assertEquals($defaultImplodeResult, '123');
    }

    /**
     * @return void
     */
    public function testsSortBy () : void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->sortBy(function(int $prev, int $next) {
            return $prev < $next;
        });

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertEquals([3, 2, 1], $items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testsUnique () : void
    {
        $collection = new Collection([1, 2, 2, 3, 3]);
        $collection->unique();

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertEquals([1, 2, 3], array_values($items->getValue($collection)));
    }

    /**
     * @return void
     */
    public function testsContains () : void
    {
        $collection   = new Collection(['one', 'two', 'three']);
        $containsOne  = $collection->contains('one');
        $containsFour = $collection->contains('four');

        self::assertTrue($containsOne);
        self::assertFalse($containsFour);

        $collection->push(new class{
            public function __toString ()
            {
                return 'tree';
            }
        });

        $containsTree = $collection->contains(new class{
            public function __toString ()
            {
                return 'tree';
            }
        });

        self::assertTrue($containsTree);

        $containsFlower = $collection->contains(new class{
            public function __toString ()
            {
                return 'flower';
            }
        });

        self::assertFalse($containsFlower);
    }

    /**
     * @return void
     */
    public function testsFirst () : void
    {
        $collection = new Collection(['one', 'two', 'three']);
        $one        = $collection->first();

        self::assertEquals('one', $one);

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertEquals($one, array_values($items->getValue($collection))[0]);
    }

    /**
     * @return void
     */
    public function testsCount () : void
    {
        $collection = new Collection(['one', 'two', 'three']);

        self::assertEquals(3, $collection->count());

        $collection->push('four')->push('five');
        self::assertEquals(5, $collection->count());

        $collection->shift();
        self::assertEquals(4, $collection->count());

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertCount(4, $items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testsIsNotEmpty () : void
    {
        $collection = new Collection(['one', 'two', 'three']);

        self::assertTrue($collection->isNotEmpty());

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testsIsEmpty () : void
    {
        $collection = new Collection();

        self::assertTrue($collection->isEmpty());

        $collection->append(['one', 'two', 'three']);

        self::assertFalse($collection->isEmpty());

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertNotEmpty($items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testsShift () : void
    {
        $collection = new Collection();

        self::assertNull($collection->shift());

        $collection->append(['one', 'two', 'three']);

        self::assertEquals('one', $collection->shift());
        self::assertEquals(2, $collection->count());

        $reflection = new ReflectionClass($collection);

        $items = $reflection->getProperty('items');
        $items->setAccessible(true);

        self::assertCount(2, $items->getValue($collection));
        self::assertEquals(['two', 'three'], $items->getValue($collection));
    }

    /**
     * @return void
     */
    public function testsOffsetExists () : void
    {
        $collection = new Collection();

        self::assertFalse($collection->offsetExists(1));

        $collection->append(['one', 'two', 'three']);

        self::assertTrue($collection->offsetExists(0));
        self::assertTrue($collection->offsetExists(1));
        self::assertTrue($collection->offsetExists(2));
        self::assertFalse($collection->offsetExists(3));
    }

    /**
     * @return void
     */
    public function testsOffsetGet () : void
    {
        $collection = new Collection(['one', 'two', 'three', 'key' => 'five']);

        self::assertEquals('one', $collection->offsetGet(0));
        self::assertEquals('two', $collection->offsetGet(1));
        self::assertEquals('three', $collection->offsetGet(2));
        self::assertEquals('five', $collection->offsetGet('key'));
    }

    /**
     * @return void
     */
    public function testsOffsetSet () : void
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->offsetSet(null ,'four');
        self::assertEquals(4, $collection->count());
        self::assertEquals('four', $collection->offsetGet(3));


        $collection->offsetSet('key' ,'five');
        self::assertEquals(5, $collection->count());
        self::assertEquals('five', $collection->offsetGet('key'));
    }

    /**
     * @return void
     */
    public function testsOffsetUnset () : void
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->offsetUnset(1);
        self::assertEquals(2, $collection->count());
        self::assertEquals('one', $collection->offsetGet(0));
        self::assertEquals('three', $collection->offsetGet(2));
    }


}

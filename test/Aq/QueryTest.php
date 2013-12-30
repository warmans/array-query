<?php
namespace Aq;

require_once(__DIR__.'/../../src/Aq/Query.php');

/**
 *  Array Query
 *
 * @author warmans
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    private $object;

    public function test_query_empty_array()
    {
        $this->object = new Query('/foo');
        $result = $this->object->apply(array());
        $this->assertFalse($result);
    }

    public function test_query_non_array()
    {
        $this->object = new Query('/foo');
        try {
            $this->object->apply(null);
            $this->fail('Exception not raised for non-array query');
        } catch (\Exception $e){}
    }

    public function test_first_level_match_string()
    {
        $this->object = new Query('/foo');
        $result = $this->object->apply(array('foo'=>'100'));
        $this->assertEquals('100', $result);
    }

    public function test_first_level_match_array()
    {
        $this->object = new Query('/foo');
        $result = $this->object->apply(array('foo'=>array('bar'=>'baz')));
        $this->assertEquals(array('bar'=>'baz'), $result);
    }

    public function test_first_level_no_match()
    {
        $this->object = new Query('/foo');
        $result = $this->object->apply(array('bar'=>'100'));
        $this->assertFalse($result);
    }

    public function test_first_level_numeric_key_match()
    {
        $this->object = new Query('/0');
        $result = $this->object->apply(array('numeric'));
        $this->assertEquals('numeric', $result);
    }

    public function test_second_level_match_string()
    {
        $this->object = new Query('/foo/bar');
        $result = $this->object->apply(array('foo'=>array('bar'=>'200')));
        $this->assertEquals('200', $result);
    }

    public function test_second_level_match_array()
    {
        $this->object = new Query('/foo/bar');
        $result = $this->object->apply(array('foo'=>array('bar'=>array('cat'=>'dog'))));
        $this->assertEquals(array('cat'=>'dog'), $result);
    }

    public function test_second_level_numeric_key_match()
    {
        $this->object = new Query('/foo/0');
        $result = $this->object->apply(array('foo'=>array(array('cat'=>'dog'))));
        $this->assertEquals(array('cat'=>'dog'), $result);
    }

    public function test_second_level_no_match()
    {
        $this->object = new Query('/foo/bar');
        $result = $this->object->apply(array('foo'=>array('baz'=>'200')));
        $this->assertFalse($result);
    }

    public function test_mixed_key_match()
    {
        $this->object = new Query('/foo/0/bar');
        $result = $this->object->apply(array('foo'=>array(array('bar'=>'200'))));
        $this->assertEquals('200', $result);
    }

    public function test_partial_match_string()
    {
        $this->object = new Query('/foo/bar/baz');
        $result = $this->object->apply(array('foo'=>array('bar'=>200)));
        $this->assertFalse($result);
    }

    public function test_partial_match_array(){
        $this->object = new Query('/foo/bar/baz');
        $result = $this->object->apply(array('foo'=>array('bar'=>array('foo'=>'bar'))));
        $this->assertFalse($result);
    }
}

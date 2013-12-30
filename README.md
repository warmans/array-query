# Array Query

Retrieve a value from within an array using an XPATH-like string. This is useful if you want to write a simple DSL that
consumes a web service.

## Example

    $q = new Query('/foo/bar/0');
    $result = $this->object->apply(array(
        'foo'=>array(
            'bar'=>array(
                'first',
                'second',
                'third'
            )
        )
    ));

    echo $result; //first

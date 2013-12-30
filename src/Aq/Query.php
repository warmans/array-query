<?php
namespace Aq;

/**
 *  Array Query
 *
 * @author warmans
 */
class Query
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function apply(array $array)
    {
        $query_keys = array_values(array_filter(explode('/', $this->query), 'strlen'));

        while ((null !== ($key = array_shift($query_keys))) && ($array !== false)) {
            //check if the current key exists
            if (is_array($array) && array_key_exists($key, $array)) {
                //value at key is either
                if (!is_array($array[$key])) {
                    if(count($query_keys) === 0) {
                        //we found the key
                        return $array[$key];
                    } else {
                        //reach string with further keys to find
                        return false;
                    }
                } else {
                    //we haven't found the key (yet)
                    $array = $array[$key];
                }
            } else {
                //key doesn't exist
                return false;
            }
        }
        return $array;
    }
}

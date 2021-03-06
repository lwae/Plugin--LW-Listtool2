<?php

namespace lwListtool\Domain\Entry\Service;

class Filter
{
    public function __construct()
    {
    }
    
    public function getInstance()
    {
        return new Filter();
    }
    
    public function filter(\LWddd\ValueObject $valueObject)
    {
        
        $values = $valueObject->getValues();
        foreach($values as $key => $value) {
            if(!is_array($value)) {
                $value = trim($value);
            }
            if ($key != "shown_opt2number") {
                $method = $key.'Filter';
                if (method_exists($this, $method)) {
                    $value = $this->$method($value);
                }
                $filteredValues[$key] = $value;
            }
        }
        return new \LWddd\ValueObject($filteredValues);
    }
    
    protected function opt1fileFilter($array)
    {
        if (strlen(trim($array['name']))<5 || $array['size']<1) {
            return false;
        }
        return $array;
    }
    
    protected function opt2fileFilter($array)
    {
        if (strlen(trim($array['name']))<5 || $array['size']<1) {
            return false;
        }
        return $array;
    }
    
    protected function publishedFilter($value)
    {
        if ($value != 1) {
            return 0;
        }
        return 1;
    }
    
    protected function descriptionFilter($value)
    {
        return base64_encode($value);
    }
    
    protected function opt1textFilter($value)
    {
        return strip_tags($value);
    }
    
    protected function opt2textFilter($value)
    {
        return strip_tags($value);
    }
    
}

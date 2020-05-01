<?php


namespace Core;


/**
 * Class DataBinder
 * @package Core
 */
class DataBinder implements DataBinderInterface
{
    /**
     * @param array $formData
     * @param object $model
     * @return object
     */
    public function bind(array $formData, object $model)
    {
        foreach ($formData as $key=>$value)
        {
            $methodName = "set" .
                implode("",
                    array_map(function ($el){
                        return ucfirst($el);
                    }, explode("_", $key)));

            if (method_exists($model, $methodName))
            {
                $model->$methodName($value);
            }
        }

        return  $model;
    }
}
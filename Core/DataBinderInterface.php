<?php


namespace Core;


/**
 * Interface DataBinderInterface
 * @package Core
 */
interface DataBinderInterface
{
    public function bind(array $formData, object $model);
}
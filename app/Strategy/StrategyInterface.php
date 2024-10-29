<?php


namespace App\Strategy;

interface StrategyInterface
{
    public function __construct($model);
    public function handle();
}
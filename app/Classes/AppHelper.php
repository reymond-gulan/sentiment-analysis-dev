<?php

namespace App\Classes;

class AppHelper
{
    public static function saved()
    {
        return "Submitted record has been saved!";
    }

    public static function deleted()
    {
        return "Record has been deleted.";
    }

    public static function updated()
    {
        return "Record has been updated.";
    }

    public static function exists()
    {
        return "Submitted data already exists";
    }
}

<?php

namespace Elit1\ObjectOriented\Forms;

class Submit
{

    public static function button ()
    {
        echo '<div class="form-group">
            <input name="submit" value="Submit" type="submit" class="btn btn-primary mt-3 mb-2">
        </div>';
    }

}
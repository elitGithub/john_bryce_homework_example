<?php

namespace Elit1\ObjectOriented;

class Card
{
    public static function cardWithImage ($src, $title, $text)
    {
        echo '<div class="card" style="width: 18rem;">
                 <img class="card-img-top img-thumbnail" style="max-width: 300px; max-height: 300px" src="'.$src.'" alt="'.$src.'">
                   <div class="card-body">
                    <h5 class="card-title">'.$title.'</h5>
                    <p class="card-text">'.$text.'</p>
                 </div>
              </div>';
    }

}
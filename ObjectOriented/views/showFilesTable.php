
<div class="row">
<?php

use Elit1\ObjectOriented\Card;
use Elit1\ObjectOriented\UploadsDir;

//
//$table = new Elit1\ObjectOriented\Table($images, ['ID', 'FileName', 'Thumbnail']);
//$table->setModel((new Elit1\ObjectOriented\Models\ImageModel()))->startTable()->headersRow()->tableBody();

foreach ($images as $image) {
    $src = UploadsDir::uploadPath() . DIRECTORY_SEPARATOR . $image['filename'];
    Card::cardWithImage($src, 'Some title', 'some text');
}

?>
</div>

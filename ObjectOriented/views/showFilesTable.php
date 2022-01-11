<?php
$table = new Elit1\ObjectOriented\Table($images, ['ID', 'FileName', 'Thumbnail']);
$table->setModel((new Elit1\ObjectOriented\Models\ImageModel()))->startTable()->headersRow()->tableBody();
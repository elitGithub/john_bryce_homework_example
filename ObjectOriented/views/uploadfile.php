<div class="container-fluid">
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="upfile" class="form-label">Choose File To upload</label>
            <input class="form-control form-control-lg" id="upfile" name="upfile" type="file">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </div>
    </form>
</div>

<?php

use Elit1\ObjectOriented\FilesHandler;
use Elit1\ObjectOriented\Helpers\CreateDirectory;
use Elit1\ObjectOriented\Helpers\DoesDirExistsValidator;

if (isset($_POST['submit'])) {
    $filesHandler = new FilesHandler();
    $filesHandler->setUploadsDir(dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads');
    if (!DoesDirExistsValidator::dirExists($filesHandler->uploadsDir)) {
        CreateDirectory::createDir($filesHandler->uploadsDir);
    }


    try {
        $ext = $filesHandler->fileValidation();
        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $fileName = $filesHandler->uploadFile($ext);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
        return;
    }

    if ($fileName) {
        $file = new Elit1\ObjectOriented\File($fileName);
        if ($file->addFileRecordToDb()) {
            Elit1\ObjectOriented\Helpers\SuccessAlert::echo('New File Record added successfully!');
        } else {
            Elit1\ObjectOriented\Helpers\ErrorAlert::echo('Error adding new file record');
        }
    }
}
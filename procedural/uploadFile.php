<?php

makeSureWeHaveUploadsDir();

if (isset($_POST['submit'])) {
    try {
        $ext = fileValidation();
        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $fileName = uploadFile($ext);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
        return;
    }

    if ($fileName) {
        addNewFileToDb($fileName, $connection);
    }
}

?>
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
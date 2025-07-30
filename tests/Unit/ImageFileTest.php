<?php

declare(strict_types=1);

test('can create the default image uploaded file', function () {
    $file = new Illuminate\Http\UploadedFile(path: public_path('assets/images/room1.jpg'), originalName: 'default.png', mimeType: 'image/png', error: UPLOAD_ERR_OK, test: true);
    $this->assertEquals('default.png', $file->getClientOriginalName());
    $this->assertEquals('image/png', $file->getClientMimeType());
    $this->assertTrue($file->isValid());
});

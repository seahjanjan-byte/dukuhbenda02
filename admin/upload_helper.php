<?php

function store_uploaded_file(array $file, string $directory, array $allowedMimeTypes = []): string|false
{
    $defaultAllowedMimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'pdf' => 'application/pdf',
    ];

    $allowedMimeTypes = $allowedMimeTypes ?: $defaultAllowedMimeTypes;

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return false;
    }

    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return false;
    }

    $temporaryPath = $file['tmp_name'] ?? '';
    if (!is_uploaded_file($temporaryPath)) {
        return false;
    }

    $extension = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
    if (!isset($allowedMimeTypes[$extension])) {
        return false;
    }

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    if ($fileInfo === false) {
        return false;
    }

    $actualMimeType = finfo_file($fileInfo, $temporaryPath);
    finfo_close($fileInfo);

    if ($actualMimeType !== $allowedMimeTypes[$extension]) {
        return false;
    }

    if ($extension !== 'pdf' && @getimagesize($temporaryPath) === false) {
        return false;
    }

    if (!is_dir($directory) || !is_writable($directory)) {
        return false;
    }

    try {
        $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Throwable $exception) {
        return false;
    }

    if (!move_uploaded_file($temporaryPath, rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $safeName)) {
        return false;
    }

    return $safeName;
}

function store_uploaded_image(array $file, string $directory): string|false
{
    return store_uploaded_file($file, $directory);
}

function remove_uploaded_file(string $directory, ?string $fileName): void
{
    if (empty($fileName) || strtolower($fileName) === 'default.jpg' || basename($fileName) !== $fileName) {
        return;
    }

    $filePath = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $fileName;
    if (is_file($filePath)) {
        unlink($filePath);
    }
}

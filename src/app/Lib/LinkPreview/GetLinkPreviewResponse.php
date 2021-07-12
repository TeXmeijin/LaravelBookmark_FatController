<?php
namespace App\Lib\LinkPreview;

final class GetLinkPreviewResponse
{
    public string $title;
    public string $description;
    public string $cover;

    public function __construct(string $title, string $description, string $cover)
    {
        $this->title = $title;
        $this->description = $description;
        $this->cover = $cover;
    }
}
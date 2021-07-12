<?php
namespace App\Lib\LinkPreview;

final class MockLinkPreview implements LinkPreviewInterface
{
    public function get(string $url): GetLinkPreviewResponse
    {
        return new GetLinkPreviewResponse(
            'モックのタイトル',
            'モックのdescription',
            'https://i.gyazo.com/634f77ea66b5e522e7afb9f1d1dd75cb.png'
        );
    }
}
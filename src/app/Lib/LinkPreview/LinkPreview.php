<?php
namespace App\Lib\LinkPreview;

use Dusterio\LinkPreview\Client;

final class LinkPreview implements LinkPreviewInterface
{
    public function get(string $url): GetLinkPreviewResponse
    {
        $response = $previewClient->getPreview('general')->toArray();
        return new GetLinkPreviewResponse($response['title'], $response['description'], $response['cover']);
    }
}



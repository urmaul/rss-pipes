<?php

namespace rsspipes\builder;

use rsspipes\rss\Feed;

interface Builder
{
    public function getContentType(): string;

    public function buildFeed(Feed $feed): string;
}

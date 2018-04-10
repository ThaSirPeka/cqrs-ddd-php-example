<?php

namespace CodelyTv\Context\Video\Module\Video\Domain;

interface VideoNotifier
{
    public function notify(Video $video);
}

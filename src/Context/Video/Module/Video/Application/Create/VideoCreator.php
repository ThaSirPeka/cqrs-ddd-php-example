<?php

declare(strict_types=1);

namespace CodelyTv\Context\Video\Module\Video\Application\Create;

use CodelyTv\Context\Video\Module\Video\Domain\Video;
use CodelyTv\Context\Video\Module\Video\Domain\VideoId;
use CodelyTv\Context\Video\Module\Video\Domain\VideoNotifier;
use CodelyTv\Context\Video\Module\Video\Domain\VideoRepository;
use CodelyTv\Context\Video\Module\Video\Domain\VideoTitle;
use CodelyTv\Context\Video\Module\Video\Domain\VideoType;
use CodelyTv\Context\Video\Module\Video\Domain\VideoUrl;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventPublisher;
use CodelyTv\Shared\Domain\CourseId;

final class VideoCreator
{
    private $repository;
    private $publisher;
    private $videoNotifier;

    public function __construct(
        VideoRepository $repository,
        DomainEventPublisher $publisher,
        VideoNotifier $videoNotifier
    ) {
        $this->repository    = $repository;
        $this->publisher     = $publisher;
        $this->videoNotifier = $videoNotifier;
    }

    public function create(VideoId $id, VideoType $type, VideoTitle $title, VideoUrl $url, CourseId $courseId)
    {
        $video = Video::create($id, $type, $title, $url, $courseId);

        $this->repository->save($video);

        $this->videoNotifier->notify($video);

        $this->publisher->publish(...$video->pullDomainEvents());
    }
}

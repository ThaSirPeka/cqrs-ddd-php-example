<?php

namespace CodelyTv\Context\Video\Module\Video\Infrastructure;

use CodelyTv\Context\Video\Module\Video\Domain\Video;
use CodelyTv\Context\Video\Module\Video\Domain\VideoNotifier;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SwiftEmailVideoNotifier implements VideoNotifier
{
    /** @var Swift_Mailer  */
    private $mailer;

    public function __construct()
    {
        $transport = (new Swift_SmtpTransport('127.0.0.1', 1025))
            ->setUsername('')
            ->setPassword('');

        $this->mailer = new Swift_Mailer($transport);
    }

    public function notify(Video $video)
    {
        $message = (new Swift_Message('New video created'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['fcogomezrengel@gmail.com'], 'Testing')
            ->setBody('Se ha publicado un nuevo video: ' . $video->title());

        $this->mailer->send($message);
    }
}

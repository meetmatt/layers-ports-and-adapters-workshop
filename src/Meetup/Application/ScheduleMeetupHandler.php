<?php
declare(strict_types=1);

namespace Meetup\Application;

use Meetup\Domain\Model\Description;
use Meetup\Domain\Model\Meetup;
use Meetup\Domain\Model\MeetupRepository;
use Meetup\Domain\Model\Name;
use Meetup\Domain\Model\ScheduledDate;

final class ScheduleMeetupHandler
{
    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    public function __construct(MeetupRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    public function handle(ScheduleMeetup $command): Meetup
    {
        $meetup = Meetup::schedule(
            Name::fromString($command->name),
            Description::fromString($command->description),
            ScheduledDate::fromPhpDateString($command->scheduledFor)
        );

        $this->meetupRepository->add($meetup);

        return $meetup;
    }
}
<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_7;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtension;
use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddActivities implements Migration, CommentExtensionAwareInterface, ActivityExtensionAwareInterface
{
    private CommentExtension $commentExtension;

    private ActivityExtension $activitieExtension;

    public function setCommentExtension(CommentExtension $commentExtension): void
    {
        $this->commentExtension = $commentExtension;
    }

    public function setActivityExtension(ActivityExtension $activityExtension): void
    {
        $this->activitieExtension = $activityExtension;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        self::addComment($this->commentExtension, $schema);
        self::addActivities($this->activitieExtension, $schema);
    }

    public static function addComment(CommentExtension $commentExtension, Schema $schema): void
    {
        $commentExtension->addCommentAssociation($schema, 'ehdev_fwb_festival_account');
    }

    public static function addActivities(ActivityExtension $activityExtension, Schema $schema): void
    {
        $activityExtension->addActivityAssociation($schema, 'oro_note', 'ehdev_fwb_festival_account', true);
        $activityExtension->addActivityAssociation($schema, 'oro_email', 'ehdev_fwb_festival_account', true);
        $activityExtension->addActivityAssociation($schema, 'orocrm_call', 'ehdev_fwb_festival_account', true);
        $activityExtension->addActivityAssociation($schema, 'orocrm_task', 'ehdev_fwb_festival_account', true);
        $activityExtension->addActivityAssociation($schema, 'oro_calendar_event', 'ehdev_fwb_festival_account', true);
    }
}

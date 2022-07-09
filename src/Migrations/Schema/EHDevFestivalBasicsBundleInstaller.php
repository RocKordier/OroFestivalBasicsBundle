<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_0\InitialFWTable;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_2\InitialStageTable;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_3\CreateSecurityArea;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_4\AddSecAreaFestivalRelation;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_5\AddActiveFlag;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_6\AddFestivalAccount;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_7\AddActivities;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_8\AddFestivalContact;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_9\AddProfession;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtension;
use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class EHDevFestivalBasicsBundleInstaller implements Installation, CommentExtensionAwareInterface, ActivityExtensionAwareInterface
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

    public function getMigrationVersion(): string
    {
        return 'v1_9';
    }

    public function up(Schema $schema, QueryBag $queries): void
    {
        /* v1_0 */
        InitialFWTable::createEhdevFwbFestivalTable($schema);
        InitialFWTable::addEhdevFwbFestivalForeignKeys($schema);

        /* v1_2 */
        InitialStageTable::createEhdevFwbStageTable($schema);
        InitialStageTable::addEhdevFwbStageForeignKeys($schema);

        /* v1_3 */
        CreateSecurityArea::createEhdevFwbSecurityAreaTable($schema);

        /* v1_4 */
        AddSecAreaFestivalRelation::createEhdevFwbSecarea2festivalTable($schema);

        /* v1_5 */
        AddActiveFlag::addField($schema);

        /* v1_6 */
        AddFestivalAccount::addFestivalAccountTable($schema);
        AddFestivalAccount::addFestivalAccountOnFestival($schema);

        /* v1_7 */
        AddActivities::addComment($this->commentExtension, $schema);
        AddActivities::addActivities($this->activitieExtension, $schema);

        /* v1_8 */
        AddFestivalContact::addFestivalContact($schema);
        AddFestivalContact::addFestivalBillingAddress($schema);
        AddFestivalContact::addContactEmail($schema);
        AddFestivalContact::addForeignKeys($schema);
        AddFestivalContact::modifyFestivalAccount($schema);

        /* v1_9 */
        AddProfession::addProfession($schema);
    }
}

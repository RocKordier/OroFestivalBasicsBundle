<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_5;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddActiveFlag implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::addField($schema);
    }

    public static function addField(Schema $schema)
    {
        $table = $schema->getTable('ehdev_fwb_festival');
        $table->addColumn('is_active', 'boolean');
    }
}

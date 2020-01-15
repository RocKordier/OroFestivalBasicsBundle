<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_9;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddProfession implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::addProfession($schema);
    }

    public static function addProfession(Schema $schema): void
    {
        $table = $schema->getTable('ehdev_fwb_contact');
        $table->addColumn('profession', 'string', ['notnull' => false, 'length' => 255]);
    }
}

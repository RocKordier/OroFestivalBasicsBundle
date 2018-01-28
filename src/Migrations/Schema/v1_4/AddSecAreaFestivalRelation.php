<?php
namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_4;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddSecAreaFestivalRelation implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::createEhdevFwbSecarea2festivalTable($schema);
    }

    public static function createEhdevFwbSecarea2festivalTable(Schema $schema)
    {
        $table = $schema->createTable('ehdev_fwb_secarea2festival');
        $table->addColumn('festival_id', 'integer');
        $table->addColumn('secare_id', 'integer');

        $table->addIndex(['festival_id']);
        $table->addIndex(['secare_id']);

        $table->setPrimaryKey(['festival_id', 'secare_id']);

        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_festival'),
            ['festival_id'],
            ['id'],
            ['onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_security_area'),
            ['secare_id'],
            ['id'],
            ['onDelete' => 'CASCADE']
        );
    }
}

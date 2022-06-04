<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class InitialStageTable implements Migration
{
    public function up(Schema $schema, QueryBag $queries): void
    {
        self::createEhdevFwbStageTable($schema);
        self::addEhdevFwbStageForeignKeys($schema);
    }

    public static function createEhdevFwbStageTable(Schema $schema): void
    {
        $table = $schema->createTable('ehdev_fwb_stage');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', []);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('festival_id', 'integer', ['notnull' => false]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addIndex(['festival_id'], 'IDX_559E64088AEBAF57', []);
        $table->addIndex(['business_unit_owner_id'], 'IDX_559E640859294170', []);
        $table->addIndex(['organization_id'], 'IDX_559E640832C8A3DE', []);
        $table->setPrimaryKey(['id']);
    }

    public static function addEhdevFwbStageForeignKeys(Schema $schema): void
    {
        $table = $schema->getTable('ehdev_fwb_stage');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_business_unit'),
            ['business_unit_owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_festival'),
            ['festival_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
    }
}

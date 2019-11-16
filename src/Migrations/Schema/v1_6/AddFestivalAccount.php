<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_6;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddFestivalAccount implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::addFestivalAccountTable($schema);
        self::addFestivalAccountOnFestival($schema);
    }

    public static function addFestivalAccountTable(Schema $schema): void
    {
        $table = $schema->createTable('ehdev_fwb_festival_account');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['updated_by_user_id']);
        $table->addIndex(['business_unit_owner_id']);
        $table->addIndex(['organization_id']);

        $table->addUniqueIndex(['name'], 'unq_festival_account_name');

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );

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
    }

    public static function addFestivalAccountOnFestival(Schema $schema): void
    {
        $table = $schema->getTable('ehdev_fwb_festival');
        $table->addColumn('festival_account_id', 'integer', ['notnull' => false]);

        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_festival_account'),
            ['festival_account_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );

        $table->addIndex(['festival_account_id']);
    }
}

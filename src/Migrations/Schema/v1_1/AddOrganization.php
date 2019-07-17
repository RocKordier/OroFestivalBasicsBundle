<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\SecurityBundle\Migrations\Schema\UpdateOwnershipTypeQuery;

class AddOrganization implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::addOrganization($schema);
        self::updateOwnership($queries);
    }

    public static function addOrganization(Schema $schema)
    {
        $table = $schema->getTable('ehdev_fwb_festival');
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addIndex(['organization_id'], 'IDX_5990A22732C8A3DE', []);
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    public static function updateOwnership(QueryBag $queryBag)
    {
        $queryBag->addQuery(
            new UpdateOwnershipTypeQuery(
                'EHDev\FestivalBasicsBundle\Entity\Festival',
                [
                    'organization_field_name' => 'organization',
                    'organization_column_name' => 'organization_id',
                ]
            )
        );
    }
}

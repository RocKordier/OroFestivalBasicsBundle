<?php
namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use EHDev\FestivalBasicsBundle\Migrations\Schema\EHDevFestivalBasicsBundleInstaller;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class InitialFWTable implements Migration
{
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::createEhdevFwbFestivalTable($schema);
        self::addEhdevFwbFestivalForeignKeys($schema);
    }

    /**
     * Create ehdev_fwb_festival table
     *
     * @param Schema $schema
     */
    public static function createEhdevFwbFestivalTable(Schema $schema)
    {
        $table = $schema->createTable('ehdev_fwb_festival');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('start_date', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('end_date', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('maxguests', 'integer', []);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addIndex(['business_unit_owner_id'], 'idx_5990a22759294170', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Add ehdev_fwb_festival foreign keys.
     *
     * @param Schema $schema
     */
    public static function addEhdevFwbFestivalForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('ehdev_fwb_festival');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_business_unit'),
            ['business_unit_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }
}

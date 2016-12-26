<?php

namespace EHDev\Bundle\FestivalBasicsBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class EHDevFestivalBasicsBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createEhdevFwbFestivalTable($schema);

        /** Foreign keys generation **/
    }

    /**
     * Create ehdev_fwb_festival table
     *
     * @param Schema $schema
     */
    protected function createEhdevFwbFestivalTable(Schema $schema)
    {
        $table = $schema->createTable('ehdev_fwb_festival');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('start_date', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('end_date', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('maxguests', 'integer', []);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->setPrimaryKey(['id']);
    }
}

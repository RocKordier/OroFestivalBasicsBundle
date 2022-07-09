<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class InitialFWTable implements Migration
{
    public function up(Schema $schema, QueryBag $queries): void
    {
        self::createEhdevFwbFestivalTable($schema);
        self::addEhdevFwbFestivalForeignKeys($schema);
    }

    public static function createEhdevFwbFestivalTable(Schema $schema): void
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

    public static function addEhdevFwbFestivalForeignKeys(Schema $schema): void
    {
    }
}

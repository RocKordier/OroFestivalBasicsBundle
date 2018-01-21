<?php
namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_3;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class CreateSecurityArea implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::createEhdevFwbSecurityAreaTable($schema);
    }

    public static function createEhdevFwbSecurityAreaTable(Schema $schema)
    {
        $table = $schema->createTable('ehdev_fwb_security_area');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->setPrimaryKey(['id']);
    }
}

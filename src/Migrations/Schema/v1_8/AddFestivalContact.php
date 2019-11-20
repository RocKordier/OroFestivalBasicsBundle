<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Migrations\Schema\v1_8;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddFestivalContact implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        self::addFestivalContact($schema);
        self::addFestivalBillingAddress($schema);
        self::addContactEmail($schema);
        self::addForeignKeys($schema);
        self::modifyFestivalAccount($schema);
    }

    public static function addFestivalContact(Schema $schema): void
    {
        $table = $schema->createTable('ehdev_fwb_contact');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('first_name', 'string', ['length' => 255]);
        $table->addColumn('last_name', 'string', ['length' => 255]);
        $table->addColumn('email', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('is_primary', 'boolean', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);

        $table->setPrimaryKey(['id']);

        $table->addIndex(['owner_id']);
    }

    public static function addFestivalBillingAddress(Schema $schema): void
    {
        $table = $schema->createTable('ehdev_fwb_billing_address');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('country_code', 'string', ['notnull' => false, 'length' => 2]);
        $table->addColumn('region_code', 'string', ['notnull' => false, 'length' => 16]);
        $table->addColumn('label', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('street', 'string', ['notnull' => false, 'length' => 500]);
        $table->addColumn('street2', 'string', ['notnull' => false, 'length' => 500]);
        $table->addColumn('city', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('postal_code', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('organization', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('region_text', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);

        $table->setPrimaryKey(['id']);

        $table->addIndex(['owner_id']);
        $table->addIndex(['country_code']);
        $table->addIndex(['region_code']);
    }

    public static function addContactEmail(Schema $schema): void
    {
        $table = $schema->createTable('ehdev_fwb_contact_email');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('email', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('is_primary', 'boolean', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);

        $table->setPrimaryKey(['id']);

        $table->addIndex(['owner_id']);
        $table->addIndex(['email', 'is_primary']);
    }

    public static function addForeignKeys(Schema $schema): void
    {
        $table = $schema->getTable('ehdev_fwb_contact');
        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_festival_account'),
            ['owner_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );

        $table = $schema->getTable('ehdev_fwb_billing_address');
        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_festival_account'),
            ['owner_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_dictionary_region'),
            ['region_code'],
            ['combined_code'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_dictionary_country'),
            ['country_code'],
            ['iso2_code'],
            ['onDelete' => null, 'onUpdate' => null]
        );

        $table = $schema->getTable('ehdev_fwb_contact_email');
        $table->addForeignKeyConstraint(
            $schema->getTable('ehdev_fwb_contact'),
            ['owner_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    public static function modifyFestivalAccount(Schema $schema): void
    {
        $table = $schema->getTable('ehdev_fwb_festival_account');
        $table->addColumn('account_manager_id', 'integer', ['notnull' => false]);

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['account_manager_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );

        $table->addIndex(['account_manager_id']);
    }
}

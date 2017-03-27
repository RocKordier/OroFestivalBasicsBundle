<?php

namespace EHDev\Bundle\FestivalBasicsBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use EHDev\Bundle\FestivalBasicsBundle\Migrations\Schema\v1_0\InitialFWTable;
use EHDev\Bundle\FestivalBasicsBundle\Migrations\Schema\v1_1\AddOrganization;
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
        return 'v1_1';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** v1_0 */
        InitialFWTable::createEhdevFwbFestivalTable($schema);
        InitialFWTable::addEhdevFwbFestivalForeignKeys($schema);
        
        /** v1_1 */
        AddOrganization::addOrganization($schema);
        AddOrganization::updateOwnership($queries);
    }
}

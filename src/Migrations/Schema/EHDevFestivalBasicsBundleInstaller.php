<?php
namespace EHDev\FestivalBasicsBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_0\InitialFWTable;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_1\AddOrganization;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_2\InitialStageTable;
use EHDev\FestivalBasicsBundle\Migrations\Schema\v1_3\CreateSecurityArea;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class EHDevFestivalBasicsBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion(): string
    {
        return 'v1_3';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        /** v1_0 */
        InitialFWTable::createEhdevFwbFestivalTable($schema);
        InitialFWTable::addEhdevFwbFestivalForeignKeys($schema);

        /** v1_1 */
        AddOrganization::addOrganization($schema);
        AddOrganization::updateOwnership($queries);

        /** v1_2 */
        InitialStageTable::createEhdevFwbStageTable($schema);
        InitialStageTable::addEhdevFwbStageForeignKeys($schema);

        /** v1_3 */
        CreateSecurityArea::createEhdevFwbSecurityAreaTable($schema);
    }
}
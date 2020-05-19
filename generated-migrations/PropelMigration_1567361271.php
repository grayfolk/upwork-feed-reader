<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1567361271.
 * Generated on 2019-09-01 21:07:51 by admin
 */
class PropelMigration_1567361271
{

    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *         the keys being the datasources
     */
    public function getUpSQL()
    {
        return array(
            'default' => 'ALTER TABLE `job` CHANGE `show` `deleted` TINYINT(1) NOT NULL DEFAULT 0, CHANGE `date` `posted` DATETIME NOT NULL;'
        );
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *         the keys being the datasources
     */
    public function getDownSQL()
    {
        return array(
            'default' => 'ALTER TABLE `job` CHANGE `deleted` `show` TINYINT(1) NOT NULL DEFAULT 1, CHANGE `posted` `date` DATETIME NOT NULL;'
        );
    }
}
<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1567206138.
 * Generated on 2019-08-31 02:02:18 by admin
 */
class PropelMigration_1567206138
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
            'default' => 'CREATE TABLE `admin_upwork`.`skill` ( `id` INT NOT NULL AUTO_INCREMENT ,  `skill` TINYTEXT NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;'
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
            'default' => 'DROP TABLE `admin_upwork`.`skill`'
        );
    }
}
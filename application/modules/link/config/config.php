<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Link\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'link',
        'version' => '1.2',
        'icon_small' => 'fa-external-link',
        'author' => 'Veldscholten, Kevin',
        'link' => 'http://ilch.de',
        'languages' => [
            'de_DE' => [
                'name' => 'Links',
                'description' => 'Hier können die Links verwaltet werden.',
            ],
            'en_EN' => [
                'name' => 'Links',
                'description' => 'Here you can manage your links.',
            ],
        ],
        'ilchCore' => '2.0.0',
        'phpVersion' => '5.6'
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
    }

    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_links`;
                                 DROP TABLE `[prefix]_link_cats`;');
    }

    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_links` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `cat_id` INT(11) NULL DEFAULT 0,
                  `pos` INT(11) NOT NULL DEFAULT 0,
                  `name` VARCHAR(100) NOT NULL,
                  `desc` varchar(191) NOT NULL,
                  `banner` varchar(191) NOT NULL,
                  `link` varchar(191) NOT NULL,
                  `hits` INT(11) NOT NULL DEFAULT 0,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;

                CREATE TABLE IF NOT EXISTS `[prefix]_link_cats` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `parent_id` INT(11) NULL DEFAULT 0,
                  `pos` INT(11) NOT NULL DEFAULT 0,
                  `name` VARCHAR(100) NOT NULL,
                  `desc` varchar(191) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;

                INSERT INTO `[prefix]_links` (`id`, `name`, `desc`, `banner`, `link`) VALUES
                (1, "ilch", "Du suchst ein einfach strukturiertes Content Management System? Dann bist du bei ilch genau richtig! ", "http://www.ilch.de/include/images/linkus/468x60.png", "http://ilch.de");';
    }

    public function getUpdate($installedVersion)
    {

    }
}

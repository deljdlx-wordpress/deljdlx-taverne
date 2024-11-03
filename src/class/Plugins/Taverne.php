<?php

namespace Deljdlx\WPTaverne\Plugins;

use Deljdlx\WPForge\Container;
use Deljdlx\WPForge\Plugin;
use Deljdlx\WPForge\Router;
use Deljdlx\WPTaverne\Controllers\Character;
use Deljdlx\WPTaverne\Controllers\PageNotFound;
use Deljdlx\WPTaverne\Models\TavEntity;
use Illuminate\Http\Request;

class Taverne extends Plugin
{
    public static function run()
    {
        $instance = static::getInstance();

        try {
            $result = $instance->router->route();

            if($result) {
                http_response_code(200);
                echo $result;
                return true;
            }
            else {
                // echo wp_forge()->view->render('layouts.home');
                $constroller = new PageNotFound($instance->getContainer());
                echo $constroller->index();
            }
        }
        catch(\Exception $e) {
            dump($e);
        }
    }

    public function __construct(Container $container,$bootstrapFile = null)
    {
        parent::__construct($container,$bootstrapFile);
        $this->router = new Router();

        $router = $this->router;
        include $this->filepath . '/src/@routes/my-desktop.php';
        include $this->filepath . '/src/@routes/__default.php';
    }


    public function initialize()
    {
        global $wpdb;
        parent::initialize();
    }


    public function activate()
    {
        global $wpdb;
        parent::activate();


        // check if bdd table ****_tav_logs exists
        $sql = "SHOW TABLES LIKE '{$wpdb->prefix}tav_logs'";
        $result = $wpdb->get_results($sql);

        if(empty($result)) {
            $query ="
                CREATE TABLE `{$wpdb->prefix}tav_logs` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `machine` VARCHAR(48) NULL DEFAULT NULL,
                    `date` DATETIME NULL DEFAULT NULL,
                    `level` INT(11) NULL DEFAULT NULL,
                    `message` LONGTEXT NULL DEFAULT NULL,
                    PRIMARY KEY (`id`) USING BTREE,
                    INDEX `machine` (`machine`) USING BTREE,
                    INDEX `date` (`date`) USING BTREE,
                    INDEX `level` (`level`) USING BTREE,
                    CONSTRAINT `message` CHECK (json_valid(`message`))
                )
                COLLATE='utf8mb4_general_ci'
                ENGINE=InnoDB
                ;
            ";
            // execute query
            $wpdb->query($query);
        }



        // check if bdd table ****tav_relations exists
        $sql = "SHOW TABLES LIKE '{$wpdb->prefix}tav_relations'";
        $result = $wpdb->get_results($sql);

        if(empty($result)) {
            $query = "
                CREATE TABLE `{$wpdb->prefix}tav_relations` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `from` INT(11),
                    `to` INT(11),
                    `caption` VARCHAR(2048) NULL DEFAULT NULL,
                    `type` VARCHAR(2048) NULL DEFAULT NULL,
                    `date` DATETIME NULL DEFAULT NULL,
                    `created_at` DATETIME NULL DEFAULT NULL,
                    `updated_at` DATETIME NULL DEFAULT NULL,
                    PRIMARY KEY (`id`) USING BTREE,
                    INDEX `from` (`from`) USING BTREE,
                    INDEX `to` (`to`) USING BTREE,
                    INDEX `type` (`type`) USING BTREE,
                    INDEX `date` (`date`) USING BTREE
                )
                COLLATE='utf8mb4_general_ci'
                ENGINE=InnoDB
                ;
            ";
            // execute query
            $wpdb->query($query);
        }
    }


}

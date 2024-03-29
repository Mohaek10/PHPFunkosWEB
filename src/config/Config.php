<?php

namespace config;


use Dotenv\Dotenv;
use PDO;


class Config
{
    private static $instance;
    private $postgresDb;
    private $postgresUser;
    private $postgresPassword;
    private $postgresHost;
    private $postgresPort;
    private $db;

    private $rootPath = '/var/www/html/public/';
    private $uploadPath = '/var/www/html/public/uploads/';
    private $uploadUrl = 'http://localhost:8080/uploads/';

    private function __construct()
    {

        $dotenv = Dotenv::createImmutable($this->rootPath);
        $dotenv->load();

        $this->postgresDb = getenv('POSTGRES_DB') ?? 'funkos';
        $this->postgresUser = getenv('POSTGRES_USER') ?? 'moha';
        $this->postgresPassword = getenv('POSTGRES_PASSWORD') ?? '12345';
        $this->postgresHost = getenv('POSTGRES_HOST') ?? 'postgres-db';
        $this->postgresPort = getenv('POSTGRES_PORT') ?? '5432';
        $this->db = new PDO("pgsql:host={$this->postgresHost};port={$this->postgresPort};dbname={$this->postgresDb}", $this->postgresUser, $this->postgresPassword);
    }

    public static function getInstance(): Config
    {
        if (!isset(self::$instance)) {
            self::$instance = new Config();
        }
        return self::$instance;
    }


    // Magic methos for get and set
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}
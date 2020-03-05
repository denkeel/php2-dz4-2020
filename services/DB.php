<?php
namespace App\services;

class DB
{
    use TSingleton;

    protected $connection;

    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'php1',
        'charset' => 'UTF8',
        'username' => 'root',
        'password' => '',
    ];

    /**
     * @return \PDO
     */
    protected function getConnection()
    {
        if (empty($this->connection)) {
            $this->connection = new \PDO(
                $this->getDsn(),
                $this->config['username'],
                $this->config['password']
            );

            $this->connection->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
        }

        return $this->connection;
    }

    private function getDsn()
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
                $this->config['driver'],
                $this->config['host'],
                $this->config['dbname'],
                $this->config['charset']
        );
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    protected function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    public function find($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function findAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function findObject($sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetch();
    }

    public function findObjects($sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetchAll();
    }

    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }

    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}

<?php

namespace app\models;

use app\engine\App;
use app\engine\Db;

abstract class Repository
{
    abstract protected function getTableName();
    abstract protected function getEntityClass();


    public function getAll() {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return App::call()->db->queryAll($sql);
    }

    public function getWhere($name, $value) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$name}=:value";
        return App::call()->db->queryOneObject($sql, ['value' => $value], $this->getEntityClass());
    }

    public function getWhereAll($name, $value) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$name}=:value";
        return App::call()->db->queryAll($sql, ['value' => $value], $this->getEntityClass());
    }

    public function getCountWhere($name, $value)  {
        $tableName = $this->getTableName();
        $sql = "SELECT count(id) as count FROM {$tableName} WHERE {$name}=:value";
        return App::call()->db->queryOne($sql, ['value' => $value])['count'];
    }


    public function getLimit($limit) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} LIMIT 0, ?";
        return App::call()->db->queryLimit($sql, $limit);
    }

    //CRUD Active Record
    //$product = (new ProductRepository())->getOne($id);
    public function getOne($id) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        // return Db::getInstance()->queryOne($sql, ['id' => $id]);
        return App::call()->db->queryOneObject($sql, ['id' => $id], $this->getEntityClass());
    }
    //$product = new Product('Чай' ...);
    //(new ProductRepository())->save($product);
    public function insert(Model $entity) {
        $params = [];
        $columns = [];

        foreach ($entity->props as $key => $value) {
            if ($key == "id" || in_array($key, $entity->protectedProps)) continue;
            $params[":{$key}"] = $entity->$key;
            $columns[] = $key;
        }

        $columns = implode(", ", $columns);
        $values = implode(", ", array_keys($params));
        $tableName = $this->getTableName();
        //INSERT INTO {$this->getTableName()}(`name`, `description`, `price`) VALUES (:name, :description, :price
        $sql = "INSERT INTO {$tableName} ($columns) VALUES ($values)";
        $insert = App::call()->db->execute($sql, $params);
        $this->id = App::call()->db->lastInsertId();
        return $insert;

    }

    //$product = (new ProductRepository())->getOne($id);
    //$product->price = 44;
    //(new ProductRepository())->save($product);
    public function update(Model $entity) {
        $params = [];
        $colums = [];
        foreach ($entity->props as $key => $value) {
            if (!$value || $value == false || $key == "id" ||  in_array($key, $entity->protectedProps)) continue;
            $params[":{$key}"] = $entity->$key;
            $colums[] .= "{$key} = :{$key}";
            $entity->props[$key] = false;
        }
        $colums = implode(", ", $colums);
        $tableName = $this->getTableName();
        $params['id'] = $entity->{$entity->keyFieldName};
        $sql = "UPDATE {$tableName} SET {$colums} WHERE $entity->keyFieldName = :id";
        return App::call()->db->execute($sql, $params);
    }

    //$product = (new ProductRepository())->getOne($id);
    //(new ProductRepository())->delete($product);
    public function delete(Model $entity) {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id"; //$this->id
        return App::call()->db->execute($sql, ['id' => $entity->id]);
    }

    //END CRUD

    public function save(Model $entity) {
        if (is_null($entity->id)) {
             $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }


}
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
        return App::call()->ormDb->table($tableName)->getAll();
        //$sql = "SELECT * FROM {$tableName}";
        //return App::call()->db->queryAll($sql);
    }

    public function getWhere($name, $value) {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->where($name, $value)->get();
        //$sql = "SELECT * FROM {$tableName} WHERE {$name}=:value";
       //return App::call()->db->queryOneObject($sql, ['value' => $value], $this->getEntityClass());
    }

    public function getWhereAll($name, $value) {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->where($name, $value)->getAll();
        //$sql = "SELECT * FROM {$tableName} WHERE {$name}=:value";
       // return App::call()->db->queryAll($sql, ['value' => $value], $this->getEntityClass());
    }

    public function getCountWhere($name, $value)  {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->count('id' , 'count')->where($name, $value)->get();
        //$sql = "SELECT count(id) as count FROM {$tableName} WHERE {$name}=:value";
        //return App::call()->db->queryOne($sql, ['value' => $value])['count'];
    }


    public function getLimit($limit) {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->limit(0, $limit);
        //$sql = "SELECT * FROM {$tableName} LIMIT 0, ?";
        //return App::call()->db->queryLimit($sql, $limit);
    }

    //CRUD Active Record
    //$product = (new ProductRepository())->getOne($id);
    public function getOne($id) {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->where('id', $id)->get();
        //$sql = "SELECT * FROM {$tableName} WHERE id = :id";
        // return Db::getInstance()->queryOne($sql, ['id' => $id]);
        //return App::call()->db->queryOneObject($sql, ['id' => $id], $this->getEntityClass());
    }
    //$product = new Product('Чай' ...);
    //(new ProductRepository())->save($product);
    public function insert(Model $entity) {
        $params = [];

        foreach ($entity->props as $key => $value) {
            if ($key == "id" || in_array($key, $entity->protectedProps)) continue;
            $params[$key] = $entity->$key;
        }

        $tableName = $this->getTableName();
        $insert = App::call()->ormDb->table($tableName)->insert($params);
        $this->id = App::call()->ormDb->insertId();
        return $insert;
    }

    //$product = (new ProductRepository())->getOne($id);
    //$product->price = 44;
    //(new ProductRepository())->save($product);
    public function update(Model $entity) {
        $params = [];
        foreach ($entity->props as $key => $value) {
            if (!$value || $value == false || $key == "id" ||  in_array($key, $entity->protectedProps)) continue;
            $params[$key] = $entity->$key;
            $entity->props[$key] = false;
        }
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->where($entity->keyFieldName,$entity->{$entity->keyFieldName})->update($params);
        //$sql = "UPDATE {$tableName} SET {$colums} WHERE $entity->keyFieldName = :id";
        //return App::call()->db->execute($sql, $params);
    }

    //$product = (new ProductRepository())->getOne($id);
    //(new ProductRepository())->delete($product);
    public function delete(Model $entity) {
        $tableName = $this->getTableName();
        return App::call()->ormDb->table($tableName)->where('id', $entity->id)->delete();
        //$sql = "DELETE FROM {$tableName} WHERE id = :id"; //$this->id
        //return App::call()->db->execute($sql, ['id' => $entity->id]);
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
<?php

namespace app\models\repositories;
use app\engine\App;
use app\models\Repository;
use app\models\entities\Diet;

class DietRepository extends Repository
{

    public function getDiet()
    {

        $sql = "SELECT  d.id, 
                        f.name, 
                        ROUND(d.count,0) as count, 
                        ROUND(f.protein*d.count/100, 1) as protein, 
                        ROUND(f.fat*d.count/100, 1) as fat, 
                        ROUND(f.carbohydrates*d.count/100, 1) as carbohydrates, 
                        ROUND(f.calories*d.count/100, 0) as calories, 
                        f.special_foods, 
                        d.session_id, 
                        d.user_id, 
                        d.diet_user_id 
                        FROM diets as d, foods as f 
                        WHERE d.foods_id = f.id AND ";
        if (isset($_SESSION['auth']['login'])) {
            $userid = $_SESSION['auth']['id'];
            $sql = $sql." d.user_id=:user_id";
            $params = [
                'user_id' => $userid
            ];
        } else {
            $session_id = App::call()->session->id();
            $sql = $sql." d.session_id=:session_id";
            $params = [
                'session_id' => $session_id
            ];
        }
        $sql = $sql . " ORDER BY name ASC";
        return App::call()->db->queryAll($sql, $params);
    }
    public function calcDiet(){
        $sql = "SELECT SUM(ROUND(f.protein*d.count/100, 1)) as sumprotein, 
                SUM(ROUND(f.fat*d.count/100, 1)) as sumfat,
                SUM(ROUND(f.carbohydrates*d.count/100, 1)) as sumcarbohydrates,
                SUM(ROUND(f.calories*d.count/100, 0)) as sumcalories
                FROM diets as d, foods as f 
                WHERE d.foods_id = f.id AND";
        if (isset($_SESSION['auth']['login'])) {
            $userid = $_SESSION['auth']['id'];
            $sql = $sql." d.user_id=:user_id";
            $params = [
                'user_id' => $userid
            ];
        } else {
            $session_id = App::call()->session->id();
            $sql = $sql." d.session_id=:session_id";
            $params = [
                'session_id' => $session_id
            ];
        }
        return App::call()->db->queryAll($sql, $params )[0];
    }

    public function addFoodDiet($diet){

        if (isset($_SESSION['auth']['login'])) {
            $diet->user_id = $_SESSION['auth']['id'];
            $diet = $this->findFoodToDiet($diet,'user_id', $diet->user_id, $diet->foods_id );
            } else {
            $diet->session_id = App::call()->session->id();
            $diet = $this->findFoodToDiet($diet,'session_id', $diet->session_id, $diet->foods_id );
        }
        return App::call()->dietRepository->save($diet);

    }


    protected function findFoodToDiet($diet,$nameid,$id, $food_id){
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}
                    WHERE foods_id = :foods_id AND {$nameid} = :{$nameid}";
        $params = [
            'foods_id' => $food_id,
            $nameid => $id
        ];
        $findfooddiet = App::call()->db->queryOneObject($sql, $params,$this->getEntityClass());

        if ($findfooddiet)
        {
            $newcount = $diet->count + $findfooddiet->count;
            $diet = $findfooddiet;
            $diet->count = $newcount;
        }
        return $diet;

    }

    public function deleteFoodToDiet($foods_id){

        if (isset($_SESSION['auth']['login'])) {
            $user_id = $_SESSION['auth']['id'];
            $delete = $this->deleteFoodToDietExecute('user_id', $user_id, $foods_id );
        } else {
            $session_id = App::call()->session->id();
            $delete = $this->deleteFoodToDietExecute('session_id', $session_id, $foods_id );
        }
        return $delete;
    }

    protected function deleteFoodToDietExecute($nameid,$id, $diet_id)
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :diet_id AND {$nameid}=:{$nameid}";
        $params = [
            'diet_id' => $diet_id,
            $nameid => $id
        ];
        return App::call()->db->execute($sql, $params);
    }

    public function deleteAllDiet(){

        if (isset($_SESSION['auth']['login'])) {
            $user_id = $_SESSION['auth']['id'];
            $deletedietarray = $this->getWhereAll('user_id', $user_id);
            foreach ($deletedietarray as $itemkey) {
                $this->deleteFoodToDietExecute('user_id', $user_id, $itemkey['id']);
            }


        } else {
            $session_id = App::call()->session->id();
            $deletedietarray = $this->getWhereAll('session_id', $session_id);
            foreach ($deletedietarray as $itemkey) {
                $this->deleteFoodToDietExecute('session_id', $session_id, $itemkey['id']);
            }

        }
        return true;
    }

    protected function getTableName()
    {
        return 'diets';
    }

    protected function getEntityClass()
    {
        return Diet::class;
    }
}
<?php


namespace app\components\cache;


use yii\caching\DbDependency;

class DbDependencyHelper
{
    public static function  generateDependency($query)
    {
        $dependencyQuery = clone $query;
        $modelClass = $query->modelClass;
        $dependencyQuery->select(['MAX('.$modelClass::tableName(). '.updated_at)']);
        $dependencySql = $dependencyQuery->createCommand()->getRawSql();
        $dependency = new DbDependency(['sql' => $dependencySql]);
        return $dependency;
    }
}
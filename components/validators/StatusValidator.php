<?php
namespace app\components\validators;

// use Yii;
use yii\validators\Validator;
 
class StatusValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->$attribute, ['Working', 'Testing', 'Done'])) {
            $this->addError($model, $attribute, 'Status must be...');
        }
    }
}
<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "short_url".
 *
 * @property int $id
 * @property string $url
 * @property string $short_code
 * @property int $max_visits
 * @property int $total_visits
 * @property int $expire
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ShortUrl extends ActiveRecord
{
    const SHORT_CODE_LENGTH = 8;

    const MAX_EXPIRE = 24; // h

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'short_url';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['total_visits', 'default', 'value' => 0],
            [['url', 'expire'], 'required'],
            [['max_visits', 'total_visits', 'created_at', 'updated_at', 'expire'], 'integer'],
            [['url', 'short_code'], 'string'],
            ['url', 'url'],
            ['expire', 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            ['expire', 'compare', 'compareValue' => self::MAX_EXPIRE, 'operator' => '<=', 'type' => 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'short_code' => Yii::t('app', 'Short Code'),
            'max_visits' => Yii::t('app', 'Max Visits'),
            'total_visits' => Yii::t('app', 'Total Visits'),
            'expire' => Yii::t('app', 'Expire (hours)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public function beforeSave($insert)
    {
        if ($insert) {
            do {
                $this->short_code = $this->generateShortCode(self::SHORT_CODE_LENGTH);
            }
            while (!$this->validateShortCodeNumbers() || !$this->validateShortCodeUpper() || !$this->validateShortCodeLower() || !$this->validateShortCodeUnique());
        }
        return parent::beforeSave($insert);
    }

    public function isActiveCode() : bool
    {
        return ($this->created_at + $this->expire * 60 * 60) >= time() && $this->total_visits < $this->max_visits;
    }

    public function saveVisit() : bool
    {
        if (!$this->isActiveCode()) {
            return false;
        }
        $this->total_visits = $this->total_visits + 1;
        return $this->save(false, ['total_visits']);
    }

    private function generateShortCode($length) : string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $strlen = strlen($characters);
        $short_code = '';
        for ($i = 0; $i < $length; $i++) {
            $short_code .= $characters[rand(0, $strlen - 1)];
        }

        return $short_code;
    }

    private function validateShortCodeUpper() : bool
    {
        return preg_match('/\p{Lu}/u', $this->short_code);
    }

    private function validateShortCodeLower() : bool
    {
        return preg_match('/\p{Ll}/u', $this->short_code);
    }

    private function validateShortCodeNumbers() : bool
    {
        return preg_match('/\p{N}/u', $this->short_code);
    }

    private function validateShortCodeUnique() : bool
    {
        return !self::find()->where(['short_code' => $this->short_code])->exists();
    }

}

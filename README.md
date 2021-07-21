<p>
Installation
</p>
1. Выполнить команду php composer update

2. Создать базу данных и настроить конфиг `config/db.php` пример:
```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
]
```
3. Выполнить команду php yii migrate



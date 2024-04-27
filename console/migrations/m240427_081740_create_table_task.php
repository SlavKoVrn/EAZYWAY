<?php
use common\models\User;
use common\models\Task;
use yii\db\Migration;
use Faker\Factory;

/**
 * Class m240427_081740_create_table_task
 */
class m240427_081740_create_table_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->date(),
            'updated_at' => $this->date(),
        ]);

        $this->createIndex('idx-task-user_id', '{{%task}}', 'user_id');

        $this->addForeignKey(
            'fk-task-user_id',
            '{{%task}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );


        $faker = Factory::create('ru_RU');

        for ($i = 1; $i <= 100; $i++) {

            $time = time();
            $user = new User;
            $user->setAttributes([
                'username' => $faker->firstName.' '.$faker->lastName,
                'auth_key' => md5(time()),
                'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'email' => $faker->email,
                'verification_token' => '',
                'status' => User::STATUS_ACTIVE,
            ],false);

            $user->save();
            echo "$user->id. $user->username - $user->email\n";

            $task = new Task;
            $task->setAttributes([
                'user_id' => $user->id,
                'title' => $faker->realText(22),
                'description' => $faker->realText(1000),
            ]);

            $task->save();
            echo "$task->id. $task->title\n";

        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->db->createCommand("DELETE FROM user WHERE id > ".User::USER_ADMIN_ID)->execute();

        $this->dropForeignKey('fk-task-user_id', '{{%task}}');
        $this->dropIndex('idx-task-user_id', '{{%task}}');
        $this->dropTable('{{%task}}');
    }

}

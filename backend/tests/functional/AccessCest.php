<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\TaskFixture;
use common\fixtures\UserFixture;

use common\models\Task;
use common\models\User;
use Yii;
use Faker\Factory;

class AccessCest
{
    const NEW_TITLE = 'Новый заголовок';
    const NEW_DESCRIPTION = 'Новое описание';
    const NEW_EMAIL = 'email@mail.ru';
    const NEW_EMAIL2 = 'email.2@mail.ru';

    private $user1, $user2, $user3;
    private $task1, $task2, $task3, $task4;

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
            'task' => [
                'class' => TaskFixture::class,
                'dataFile' => codecept_data_dir() . 'task_data.php'
            ]
        ];
    }

    public function _before()
    {
        $this->user1 = User::findOne(1);
        $this->user2 = User::findOne(2);
        $this->user3 = User::findOne(3);

        $this->task1 = Task::findOne(1);
        $this->task2 = Task::findOne(2);
        $this->task3 = Task::findOne(3);
        $this->task4 = Task::findOne(4);
    }

    /**
     * @param FunctionalTester $I
     */
    public function accessErau(FunctionalTester $I)
    {
        $username = 'erau';
        $userModel = User::findByUsername($username);
        $I->amLoggedInAs($userModel);

        $faker = Factory::create('ru_RU');
        $title = $faker->realText(22);
        $description = $faker->realText(500);

        $I->amOnRoute('task/create');
        $I->fillField("//input[@id='task-title']", $title);
        $I->fillField("//textarea[@id='task-description']", $description);
        $I->click('#create-task button[type=submit]');

        $I->see($username);
        $I->see($title);
        $I->see($description);

        $I->seeRecord('common\models\Task', [
            'title' => $title,
            'description' => $description,
        ]);

        $I->amOnRoute('task/view', ['id'=>$this->task3->id]);
        $I->see($this->task3->title);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/task/update?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
            'Task[title]' => self::NEW_TITLE,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('', $pageSource);

        $I->seeRecord('common\models\Task', [
            'id' => $this->task3->id,
            'title' => self::NEW_TITLE,
            'description' => $this->task3->description,
        ]);

        $I->sendAjaxPostRequest('/admin/task/delete?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
        ]);

        $I->dontSeeRecord('common\models\Task', [
            'id' => $this->task3->id,
        ]);

        $I->amOnRoute('user/view', ['id' => $userModel->id]);
        $I->see($userModel->email);

        $I->amOnRoute('user/view', ['id' => $this->user1->id]);
        $I->dontSee($this->user1->email);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$userModel->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL,
        ]);

        $I->seeRecord('common\models\User', [
            'id' => $userModel->id,
            'email' => self::NEW_EMAIL,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$this->user1->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('Not Found (#404): The requested page does not exist.', $pageSource);

    }


    /**
     * @param FunctionalTester $I
     */
    public function accessSlavko(FunctionalTester $I)
    {
        $username = 'slavko';
        $userModel = User::findByUsername($username);
        $I->amLoggedInAs($userModel);

        $I->amOnRoute('task/index');
        $I->see($username);

        $I->amOnRoute('task/view', ['id'=>$this->task3->id]);
        $I->see('Not Found (#404)');

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/task/update?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
            'Task[title]' => self::NEW_TITLE,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('Not Found (#404): The requested page does not exist.', $pageSource);

        $I->dontSeeRecord('common\models\Task', [
            'id' => $this->task3->id,
            'title' => self::NEW_TITLE,
            'description' => $this->task3->description,
        ]);

        $I->sendAjaxPostRequest('/admin/task/delete?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('Not Found (#404): The requested page does not exist.', $pageSource);

        $I->amOnRoute('user/view', ['id' => $userModel->id]);
        $I->see($userModel->email);

        $I->amOnRoute('user/view', ['id' => $this->user1->id]);
        $I->dontSee($this->user1->email);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$userModel->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL,
        ]);

        $I->seeRecord('common\models\User', [
            'id' => $userModel->id,
            'email' => self::NEW_EMAIL,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$this->user1->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('Not Found (#404): The requested page does not exist.', $pageSource);

    }

    /**
     * @param FunctionalTester $I
     */
    public function accessAdmin(FunctionalTester $I)
    {
        $username = 'admin';

        $userModel = User::findByUsername($username);
        $I->amLoggedInAs($userModel);

        $I->amOnRoute('task/index');
        $I->see($username);

        $I->amOnRoute('task/view', ['id'=>$this->task3->id]);
        $I->see($this->task3->title);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/task/update?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
            'Task[title]' => self::NEW_TITLE,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('', $pageSource);

        $I->seeRecord('common\models\Task', [
            'id' => $this->task3->id,
            'title' => self::NEW_TITLE,
            'description' => $this->task3->description,
        ]);

        $I->sendAjaxPostRequest('/admin/task/delete?id='.$this->task3->id, [
            '_csrf-backend' => $csrfToken,
        ]);
        $pageSource = $I->grabPageSource();
        $I->assertEquals('', $pageSource);

        $I->dontSeeRecord('common\models\Task', [
            'id' => $this->task3->id,
        ]);

        $I->amOnRoute('user/view', ['id' => $userModel->id]);
        $I->see($userModel->email);

        $I->amOnRoute('user/view', ['id' => $this->user1->id]);
        $I->see($this->user1->email);


        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$userModel->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL,
        ]);

        $I->seeRecord('common\models\User', [
            'id' => $userModel->id,
            'email' => self::NEW_EMAIL,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/user/update?id='.$this->user2->id, [
            '_csrf-backend' => $csrfToken,
            'User[email]' => self::NEW_EMAIL2,
        ]);
        $I->seeRecord('common\models\User', [
            'id' => $this->user2->id,
            'email' => self::NEW_EMAIL2,
        ]);


    }

}

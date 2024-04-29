<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\fixtures\TaskFixture;
use common\models\Task;
use common\models\User;

use Yii;
use Faker\Factory;

class SearchCest
{
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
    public function searchTask(FunctionalTester $I)
    {
        //#########################################
        $username = 'erau';
        $I->amLoggedInAs(\common\models\User::findByUsername($username));

        $I->amOnRoute('task/index');

        $I->seeRecord('common\models\Task', [
            'id' => 1,
            'user_id' => 2,
        ]);

        $I->see($this->task3->title);
        $I->see($this->task4->title);

        $I->dontSee($this->task1->title);
        $I->dontSee($this->task2->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[title]' => $this->task3->title
        ]);

        $I->see($this->task3->title);
        $I->dontSee($this->task4->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[title]' => $this->task4->title
        ]);

        $I->see($this->task4->title);
        $I->dontSee($this->task3->title);

        $I->amOnRoute('user/index');

        $I->see($this->user3->username);
        $I->see($this->user3->email);
        $I->dontSee($this->user1->username);
        $I->dontSee($this->user1->email);
        $I->dontSee($this->user2->username);
        $I->dontSee($this->user2->email);
        //#########################################
        $username = 'slavko';
        $I->amLoggedInAs(\common\models\User::findByUsername($username));

        $I->amOnRoute('task/index');

        $I->see($this->task1->title);
        $I->see($this->task2->title);

        $I->dontSee($this->task3->title);
        $I->dontSee($this->task4->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[title]' => $this->task1->title
        ]);

        $I->see($this->task1->title);
        $I->dontSee($this->task2->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[title]' => $this->task2->title
        ]);

        $I->see($this->task2->title);
        $I->dontSee($this->task1->title);

        $I->amOnRoute('user/index');

        $I->see($this->user2->username);
        $I->see($this->user2->email);
        $I->dontSee($this->user1->username);
        $I->dontSee($this->user1->email);
        $I->dontSee($this->user3->username);
        $I->dontSee($this->user3->email);
        //#########################################
        $username = 'admin';
        $I->amLoggedInAs(\common\models\User::findByUsername($username));

        $I->amOnRoute('task/index');

        $I->see($this->task1->title);
        $I->see($this->task2->title);
        $I->see($this->task3->title);
        $I->see($this->task4->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[id]' => $this->task1->id
        ]);

        $I->see($this->task1->title);
        $I->dontSee($this->task2->title);
        $I->dontSee($this->task3->title);
        $I->dontSee($this->task4->title);

        $I->amOnRoute('task/index', [
            'TaskSearch[title]' => $this->task2->title
        ]);

        $I->dontSee($this->task1->title);
        $I->see($this->task2->title);
        $I->dontSee($this->task3->title);
        $I->dontSee($this->task4->title);

        $I->amOnRoute('user/index');

        $I->see($this->user1->username);
        $I->see($this->user1->email);
        $I->see($this->user2->username);
        $I->see($this->user2->email);
        $I->see($this->user3->username);
        $I->see($this->user3->email);

        $I->amOnRoute('user/index',[
            'UserSearch[username]' => $this->user2->username
        ]);

        $I->see($this->user2->email);
        $I->dontSee($this->user1->email);
        $I->dontSee($this->user3->email);
        //#########################################
    }

}

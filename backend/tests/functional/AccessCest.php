<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

use Yii;
use Faker\Factory;

class AccessCest
{
    const PASSWORD = 'password_0';

    private $record;

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
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function createTask(FunctionalTester $I)
    {
        //#########################################
        $username = 'erau';
        $I->amLoggedInAs(\common\models\User::findByUsername($username));

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

        $this->record = $I->grabRecord('common\models\Task', [
            'title' => $title,
            'description' => $description,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/site/logout', ['_csrf-backend' => $csrfToken]);
        //#########################################
        $username = 'slavko';

        $I->amLoggedInAs(\common\models\User::findByUsername($username));
        $I->amOnRoute('task/index');
        $I->see($username);

        $I->seeRecord('common\models\Task', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'description' => $this->record->description,
        ]);

        $I->amOnRoute('task/view', ['id'=>$this->record->id]);
        $I->see('Not Found (#404)');

        $I->amOnRoute('task/update', ['id'=>$this->record->id]);
        $I->see('Not Found (#404)');

        $I->amOnRoute('task/index');
        $I->sendAjaxPostRequest('/admin/task/delete?id='.$this->record->id, [
            '_csrf-backend' => $csrfToken,
        ]);

        $pageSource = $I->grabPageSource();
        $I->assertEquals('Not Found (#404): The requested page does not exist.', $pageSource);

        $I->seeRecord('common\models\Task', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'description' => $this->record->description,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/site/logout', ['_csrf-backend' => $csrfToken]);
        //#########################################
        $username = 'erau';

        $I->amLoggedInAs(\common\models\User::findByUsername($username));
        $I->amOnRoute('task/index');
        $I->see($username);

        $I->seeRecord('common\models\Task', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'description' => $this->record->description,
        ]);

        $I->amOnRoute('task/view', ['id'=>$this->record->id]);
        $I->see($this->record->title);

        $I->amOnRoute('task/update', ['id'=>$this->record->id]);
        $I->see($this->record->title);

        $I->amOnRoute('task/index');
        $I->sendAjaxPostRequest('/admin/task/delete?id='.$this->record->id, [
            '_csrf-backend' => $csrfToken,
        ]);

        $pageSource = $I->grabPageSource();
        $I->assertEquals('', $pageSource);

        $I->dontSeeRecord('common\models\Task', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'description' => $this->record->description,
        ]);

        $csrfToken = Yii::$app->request->csrfToken;
        $I->sendAjaxPostRequest('/admin/site/logout', ['_csrf-backend' => $csrfToken]);
        //#########################################
    }

}

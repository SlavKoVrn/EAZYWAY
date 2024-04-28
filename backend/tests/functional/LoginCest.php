<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Faker\Factory;

/**
 * Class LoginCest
 */
class LoginCest
{
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
    public function loginUserCreateTask(FunctionalTester $I)
    {
        $login = 'erau';
        $password = 'password_0';

        $I->amOnRoute('site/login');
        $I->fillField("//input[@id='loginform-email']", $login);
        $I->fillField("//input[@id='loginform-password']", $password);
        $I->click('#login-form button[type=submit]');

        $faker = Factory::create('ru_RU');
        $title = $faker->realText(22);
        $description = $faker->realText(500);

        $I->amOnRoute('task/create');
        $I->fillField("//input[@id='task-title']", $title);
        $I->fillField("//textarea[@id='task-description']", $description);
        $I->click('#create-task button[type=submit]');

        $I->seeRecord('common\models\Task', [
            'title' => $title,
            'description' => $description,
        ]);
        $I->see($login);
        $I->see($title);
        $I->see($description);
    }
}

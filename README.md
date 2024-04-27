<div class=WordSection1>

<p class=MsoNormal><b><span style='font-size:12.0pt;line-height:107%;
font-family:"Times New Roman","serif"'>Тестовое задание: Разработка простого
веб-приложения на Yii2<o:p></o:p></span></b></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Цель</span></b><span
style='font-family:"Times New Roman","serif"'>: Создать веб-приложение, <span
class=GramE>которое</span> позволит пользователям зарегистрироваться, войти в
систему и просматривать список задач. Пользователи должны иметь возможность
добавлять, редактировать и удалять свои задачи.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-size:12.0pt;line-height:107%;
font-family:"Times New Roman","serif"'>Требования</span></b><span
style='font-size:12.0pt;line-height:107%;font-family:"Times New Roman","serif"'>:<o:p></o:p></span></p>

<p class=MsoNormal><span style='font-family:"Times New Roman","serif"'>Регистрация
и аутентификация пользователей: Пользователи должны иметь возможность
зарегистрироваться, указав свое имя, адрес электронной почты и пароль.
Зарегистрированные пользователи должны иметь возможность войти в систему,
используя свой адрес электронной почты и пароль.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>CRUD
для задач</span></b><span style='font-family:"Times New Roman","serif"'>:
Зарегистрированные пользователи должны иметь возможность создавать новые
задачи, просматривать список своих задач, редактировать и удалять свои задачи.
Каждая задача должна иметь заголовок и описание.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Безопасность</span></b><span
style='font-family:"Times New Roman","serif"'>: Приложение должно предотвращать
любые попытки SQL-инъекции и XSS-атак. Пароли пользователей должны храниться в
хешированном виде.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Валидация</span></b><span
style='font-family:"Times New Roman","serif"'>: Все входные данные должны быть
должным образом проверены и <span class=SpellE>валидированы</span>.<o:p></o:p></span></p>

<p class=MsoNormal><span style='font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-size:12.0pt;line-height:107%;
font-family:"Times New Roman","serif"'>Дополнительные задачи (не обязательны,
но будут плюсом):<o:p></o:p></span></b></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Пагинация</span></b><span
style='font-family:"Times New Roman","serif"'>: Добавьте пагинацию для списка
задач.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Фильтрация</span></b><span
style='font-family:"Times New Roman","serif"'>: Добавьте возможность фильтрации
задач по заголовку.<o:p></o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"Times New Roman","serif"'>Тестирование</span></b><span
style='font-family:"Times New Roman","serif"'>: Напишите <span class=SpellE>unit</span>-тесты
для основных компонентов вашего приложения.<o:p></o:p></span></p>

<p class=MsoNormal><span style='font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-size:12.0pt;line-height:107%;
font-family:"Times New Roman","serif"'>Сдача задания:<o:p></o:p></span></b></p>

<p class=MsoNormal><span style='font-family:"Times New Roman","serif"'>Вы
можете использовать любой удобный для вас способ предоставления вашего кода для
проверки (<span class=SpellE>GitHub</span>, <span class=SpellE>Bitbucket</span>,
архив и т.д.). Пожалуйста, включите инструкции по установке и запуску вашего
приложения.<o:p></o:p></span></p>

</div>

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

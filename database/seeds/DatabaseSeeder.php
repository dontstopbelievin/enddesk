<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('usertypes')->insert([
        ['name' => 'Главный Админ',],
        ['name' => 'Администратор',],
          ['name' => 'Пользователь',]
    ]);
      DB::table('users')->insert([
        ['name' => 'Админ 1',
          'email' => 'admin_1@gmail.com',
          'usertype_id' => '1',
          'showtag' => 'all',
          'timelapse' => '5000',
          'per_page' => '10',
          'password' => bcrypt('123123')],
        ['name' => 'Админ 2',
          'email' => 'admin_2@gmail.com',
          'usertype_id' => '2',
          'showtag' => 'all',
          'timelapse' => '5000',
          'per_page' => '10',
          'password' => bcrypt('123123')],
        ['name' => 'Админ 3',
          'email' => 'admin_3@gmail.com',
          'usertype_id' => '3',
          'showtag' => 'all',
          'timelapse' => '5000',
          'per_page' => '10',
          'password' => bcrypt('123123')]
    ]);
      DB::table('categories')->insert([
        ['name' => 'Подключить принтер'],
        ['name' => 'Проблемы с интернетом'],
        ['name' => 'Проблемы с Операционной системой'],
        ['name' => 'Проблемы с Outlook'],
        ['name' => 'Проблемы с Office'],
        ['name' => 'Проблемы с браузером'],
        ['name' => 'Проблемы с принтером'],
        ['name' => 'Проблемы с кабелем'],
        ['name' => 'Проблемы с телефоном'],
        ['name' => 'Проблемы с паролем'],
        ['name' => 'Установка ПО']
      ]);
      DB::table('priorities')->insert([
        ['name' => 'Низкий'],
        ['name' => 'Средний'],
        ['name' => 'Высокий'],
        ['name' => 'СРОЧНО']
      ]);
      DB::table('statuses')->insert([
        ['name' => 'Открыт'],
        ['name' => 'В процессе'],
        ['name' => 'Сделано']
      ]);
      DB::table('requests')->insert([
        ['category_id' => '2',
        'priority_id' => '3',
        'status_id' => '1',
        'username' => 'Иван',
        'email' => 'ivan_sergeevich@mail.ru',
        'cabinet' => '1202',
        'theme' => 'Интернет на компьютере',
        'message' => 'Кабель подключен и работает, но нет доступа в интернет',
        'created_at' => '2018-02-08 14:03:35'],
        ['category_id' => '2',
        'priority_id' => '3',
        'status_id' => '1',
        'username' => 'Азамат',
        'email' => 'azamat@mail.ru',
        'cabinet' => '1202',
        'theme' => 'Браузер Хром',
        'message' => 'Браузер хром сохранил мою историю, как удаилть, напишите мне, я сам удалю',
        'created_at' => '2018-02-08 14:03:35'],
        ['category_id' => '2',
        'priority_id' => '3',
        'status_id' => '1',
        'username' => 'Я гейбен',
        'email' => 'gaben@valve.org',
        'cabinet' => '1202',
        'theme' => 'Хотите новость?',
        'message' => 'Валв выпустила халфу 3',
        'created_at' => '2018-02-08 14:03:35']
      ]);
    }
}

<?php

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'index';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if (!empty($routes[1]))
        {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if (!empty($routes[2]))
        {
            $action_name = $routes[2];
        }

        // добавляем префиксы
         $model_name = 'M_'.$controller_name;
         $controller_name = 'C_'.$controller_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name).'.php';
        $model_path = "model/" . $model_file;
        if (file_exists($model_path))
        {
            include "model/" . $model_file;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "controller/" . $controller_file;
        if (file_exists($controller_path))
        {
            include "controller/" . $controller_file;
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            Route::ErrorPage404();
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action))
        {
        // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
        // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('Location:' . $host . 'notFound');
    }
}
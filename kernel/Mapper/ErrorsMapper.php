<?php

namespace Pastebin\Kernel\Mapper;

class ErrorsMapper
{
    private static array $errorsMapper = [
        'name' => [
            'required' => 'Имя не должно быть пустым',
            'name' => 'Имя может содержать следующие символы: a-z, A-Z, 0-9, -, _',
            'max' => 'Имя должно содержать не более 100 символов',
            'unique' => 'Это имя уже занято',
            'exists' => 'Нет пользователя с таким именем'
        ],
        'email' => [
            'required' => 'E-mail не должен быть пустым',
            'email' => 'Неверный формат e-mail',
            'unique' => 'Этот e-mail уже занят',
            'exists' => 'Нет пользователя с таким e-mail'
        ],
        'password' => [
            'required' => 'Пароль не должен быть пустым',
            'min' => 'Пароль должен содержать не менее 12 символов',
            'max' => 'Пароль должен содержать не более 50 символов'
        ],
        'new_password' => [
            'required' => 'Новый пароль не должен быть пустым',
            'min' => 'Новый пароль должен содержать не менее 12 символов',
            'max' => 'Новый пароль должен содержать не более 50 символов',
            'confirmed' => 'Новый пароль не совпадает с полем для подтверждения'
        ],
        'new_password_confirmation' => [
            'required' => 'Подтверждение пароля не должно быть пустым',
            'min' => 'Подтверждение пароля должно содержать не менее 12 символов',
            'max' => 'Подтверждение пароля должно содержать не более 50 символов'
        ],
        'text' => [
            'required' => 'Нельзя создать пустой пост'
        ],
        'title' => [
            'max' => 'Заголовок должен содержать не более 255 символов'
        ],
        'category_id' => [
            'required' => 'Выберите категорию'
        ],
        'syntax_id' => [
            'required' => 'Выберите подсветку текста'
        ],
        'interval_id' => [
            'required' => 'Выберите время жизни поста'
        ],
        'post_visibility_id' => [
            'required' => 'Настройте доступ к посту'
        ]
    ];

    public static function getReadableError(string $field, string $error): string
    {
        return self::$errorsMapper[$field][$error];
    }
}

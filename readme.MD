# Бандл для Битрикс + Symfony, предназначенный для работы с Web формами

## Зачем?

Ясно, что удобнее результаты форм сохранять в инфоблоках, но, _к сожалению_, приходится иметь дело с веб-формами. Чаще, 
чем хотелось бы. Потому возникло желание облегчить себе жизнь, когда приходится сталкиваться с ними. 

Плюс набор валидаторов, совместимых с битриксовыми, для веб-форм (подцепляются автоматически при загрузке бандла).

**INTERNAL**

## Установка

`composer require proklung/bitrix-webform-bundle`

## Валидаторы

1) **Email** - при помощи [https://github.com/egulias/EmailValidator]()
2) **Laravel Validator** - при помощи [https://github.com/illuminate/validation](Illuminate Validation)
3) **Валидатор на число**
4) **Валидатор телефонного номера** - при помощи [https://github.com/giggsey/libphonenumber-for-php]()
5) **Валидатор на длину текста** (минимальная, максимальная)
5) **Валидатор на уникальность значения поля** - есть ли уже такое значение этого поля в базе веб-форм. Например,
можно ограничить таким образом введение много раз одного email или телефона.
5) **Валидатор на правильный http адрес**

## Примеры

Вспомогательный сервис `CreateWebForm`, предназначенный для _более-менее_ комфортного создания форм (например, в миграциях).



## Примеры

#### Сохранение результатов

Именование полей: ответ формы называется NAME, в массиве параметрах процессора форм тоже должен 
быть элемент с ключом NAME. 

```php
use Prokl\BitrixWebformBundle\Services\FormProcessor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends AbstractController
{
  public function action(Request $request, FormProcessor $processor) : Response 
  {
      $params = $request->request->all();
      $result = $processor->setFormCode('TESTING_FORM')
                          ->setData($params)
                          ->processForm();

      return new Response(['id_answer' => $result]);  
  
  }
}
```


```php

```

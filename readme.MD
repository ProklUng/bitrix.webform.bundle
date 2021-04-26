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
2) **Laravel Validator** - при помощи [https://github.com/illuminate/validation]()
3) **Валидатор на число**
4) **Валидатор телефонного номера** - при помощи [https://github.com/giggsey/libphonenumber-for-php]()
5) **Валидатор на длину текста** (минимальная, максимальная)
5) **Валидатор на уникальность значения поля** - есть ли уже такое значение этого поля в базе веб-форм. Например,
можно ограничить таким образом введение много раз одного email или телефона.
5) **Валидатор на правильный http адрес**

## Примеры

Вспомогательный сервис `CreateWebForm`, предназначенный для _более-менее_ комфортного создания форм (например, в миграциях).

```php
use Prokl\BitrixWebformBundle\Services\Migrations\CreateWebForm;

/**
 * @var CreateWebForm $creator
 */
$creator = container()->get('bitrix_form_bundle.create_form');

$creator->deleteFormByCode('TESTING_FORM');
$creator->setNameForm('Тестировочная форма')
        ->setMenuItem(['ru' => 'Тестировочная форма', 'en' => 'Testing'])
        ->setSort(1000)
        ->setSidForm('TESTING_FORM')
        ->createForm()
        ->addTextField('EMAIL', 'Электронный адрес')
        ->addRadioButtonYesNow('RIGHTS', 'Вы гуманоид?')
        ->addTextField('NAME', 'Ваше имя')
        ->addTextareaField('COMMENTS', 'Комментарии')
        ->addDropdown('DROPS', 'Список', [
            'LIST1', 'LIST2'
        ])
        ->addQuestions()
        ->createEmailTemplate()
        ->createStatus();
```

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

#### Поиск по формам

Именование полей - как и при сохранении результата.

```php
use Prokl\BitrixWebformBundle\Services\FormSearcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends AbstractController
{
  public function action(Request $request, FormSearcher $searcher) : Response 
  {
        /**
        $params = [
            'NAME' => '1111',
            'EMAIL' => 'email@email.ru',
        ];
       */
      $params = $request->request->all();
       
      $result = $searcher->addFilter($params)
                          ->setIdForm(8) // Допустимо использовать setFormCode('Символьный код формы')
                          ->exist();
        
      return new Response(['already_exists' => $result]);  
  
  }
}

```

#### Хэлперы работы с формами

Класс `FormManager`:

- ```getFormIdBySID(string $sid)``` - ID формы по символьному коду;
- ```getFormAnswers(string $sid)``` - Ответы формы (не учитывает множественные вопросы!);
- ```getAllAnswersByIdQuestion(string $formCode, string $codeQuestion)``` - Все ответы по коду вопроса;
- ```getAnswersForm($questionID)``` - Ответ по ID вопроса;

Класс `FormResult`:

- ```add(int $idWebform, array $arValuesForm = [])``` - Добавить в модуль веб-формы в форму данные. Входные
параметры - в битриксовом формате. Что-то типа:

```html
<pre>array (
     *   [WEB_FORM_ID] => 3
     *   [web_form_submit] => Отправить
     *
     *   [form_text_18] => aafafsfasdf
     *   [form_text_19] => q1241431342
     *   [form_text_21] => afsafasdfdsaf
     *   [form_textarea_20] =>
     *   [form_text_22] => fasfdfasdf
     *   [form_text_23] => 31243123412
     *
     *   18, 19, 21 - ID ответов у вопросов
     *   )</pre>
```

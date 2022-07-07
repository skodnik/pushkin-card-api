![phpunit tests](https://github.com/skodnik/pushkin-card-api/actions/workflows/php.yml/badge.svg)

# Работа с билетами в рамках программы «Пушкинская карта»
API для передачи информации в реестр сведений о билетах - [docs.culture.ru/tickets](https://docs.culture.ru/tickets/)

Официальная документация - [docs.culture.ru/documents](https://docs.culture.ru/documents)

## Требования
- php 8.1 и выше
- php-ext-curl
- php-ext-json
- php-ext-mbstring

## Установка библиотеки
```bash
composer require vlsv/pushkin-card-api
```

## Использование
```php
require_once(__DIR__ . '/vendor/autoload.php');

$config = new ClientConfig(
    accessToken: 'your_access_token',
    host: 'https://pushka-uat.test.gosuslugi.ru/api/v1'
);

$visitor = new \Vlsv\PushkinCardApi\Model\Visitor(...);
$buyer = new \Vlsv\PushkinCardApi\Model\Buyer(...);
$session = new \Vlsv\PushkinCardApi\Model\Session(...);
$payment = new \Vlsv\PushkinCardApi\Model\Payment(...);

$createTicketRequest = new \Vlsv\PushkinCardApi\Model\CreateTicketRequest(
    barcode: $barcode,
    barcode_type: $barcodeType,
    visitor: $visitor,
    buyer: $buyer,
    session: $session,
    payment: $payment,
    comment: ''
);

$apiClient = new ApiClient(
    client: new GuzzleHttp\Client(),
    config: $config
);

// Добавление билета в реестр.
try {
    $ticket = $apiClient->postTicket($createTicketRequest);
    
    echo $ticket->getId();
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}

// Больше примеров использования в тестах.
```

## API Endpoints

- UAT - https://pushka-uat.test.gosuslugi.ru/api/v1
- PROD - https://pushka.gosuslugi.ru/api/v1/

### Продавцы билетов
| Метод                                   | Запрос                                             | Описание                                |
|-----------------------------------------|----------------------------------------------------|-----------------------------------------|
| **ticketsPost**                         | **POST** /tickets                                  | Добавление билета в реестр              |
| **ticketsIdGet**                        | **GET** /tickets/{id}                              | Получение информации о билете           |
| **ticketsIdRefundPut**                  | **PUT** /tickets/{id}/refund                       | Вернуть билет                           |
| **ticketsIdVisitPut**                   | **PUT** /tickets/{id}/visit                        | Погасить билет                          |

### Контролёры билетов
| Метод                                   | Запрос                                             | Описание                                |
|-----------------------------------------|----------------------------------------------------|-----------------------------------------|
| **eventsEventIdTicketsBarcodeGet**      | **GET** /events/{event_id}/tickets/{barcode}       | Получение информации о сеансе по билету |
| **eventsEventIdTicketsBarcodeVisitPut** | **PUT** /events/{event_id}/tickets/{barcode}/visit | Погасить билет                          |

## Тесты
Создать и настроить переменные окружения в файле `phpunit.xml`. `EVENT_ID`, `ORGANIZATION_ID`, `ACCESS_TOKEN`, `UAT_HOST` запросить в службе поддержки [docs.culture.ru/](https://docs.culture.ru/).
```bash
cp phpunit.xml.dist phpunit.xml
```

### Запуск тестов
Все группы.
```bash
composer tests
```

Только юнит.
```bash
composer tests-unit
```

Только интеграционные.
```bash
composer tests-integration
```
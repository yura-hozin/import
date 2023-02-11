<?php


namespace backend\modules\import;


use app\web\theme\module\models\OrderExtendModel;
use yii\httpclient\Client;

/**
 * Модуль для работы с web-сервисом
 * Class WebServiceModel
 * @package app\web\theme\module\backend\models
 */
class WebServiceModel
{
    static function run()
    {
        echo "index empty";
    }

    /**
     * Получаем информацию о web-серсвисе
     */
    static public function getInfoWebservice()
    {
        return self::toWebservice("/api/client-info");
    }

    /**
     * Отправить заказ на web-сервис
     */
    static public function sendOrderToWebservice($orders_for_json)
    {
        $str_json = \GuzzleHttp\json_encode($orders_for_json);
        return self::toWebservicePost("/api/send-order", ['orders' => $str_json]);
    }

    /**
     * Делаем запрос на новый импорт. На Web-сервисе это экспорт.
     */
    static public function neadImport()
    {
        return self::toWebservice("/api/nead-export");
    }

    /**
     * Отправить запрос на web-сервис
     * @param $path
     * @return bool|string
     */
    static private function toWebservice($path)
    {
        $user_id = 0;
        $config = require(\Yii::getAlias('@backend/config/params.php'));
        $mytoken = $config['webservice']['token'];
        $url = $config['webservice']['url'].$path;

        $headers = array(
            'cache-control: max-age=0',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
            'sec-fetch-user: ?1',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'x-compress: null',
            'sec-fetch-site: none',
            'sec-fetch-mode: navigate',
            'accept-encoding: deflate, br',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'HTTP_APPLICATIONTOKEN: '.$mytoken,
            'HTTP_REFERER: '.$_SERVER['SERVER_NAME']
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_2) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7');

        $result = curl_exec($ch);
//        echo $result;die();
        curl_close($ch);

        return (!empty($result)) ? json_decode($result) : null;
    }

    /**
     * Отправить запрос на web-сервис
     * @param $path
     * @return bool|string
     */
    static private function toWebservicePost($path, $post)
    {
        $config = require(__DIR__ . '/../../config/params-local.php');
        $mytoken = $config['webservice']['token'];
        $url = $config['webservice']['url'].$path;
        $domain = isset($_SERVER['SERVER_NAME'])? $_SERVER['SERVER_NAME'] : '';

        $headers = array(
            'cache-control: max-age=0',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
            'sec-fetch-user: ?1',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'x-compress: null',
            'sec-fetch-site: none',
            'sec-fetch-mode: navigate',
            'accept-encoding: deflate, br',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'HTTP_APPLICATIONTOKEN: '.$mytoken,
            'HTTP_REFERER: '.$domain
        );

        if (empty($post)) $post = array();

        $client = new Client();
        $response = $client->createRequest()
            ->setHeaders($headers)
            ->setMethod('post')
            ->setUrl($url)
            ->setData($post)
            ->send();
        if ($response->isOk) {
            echo $response->content;
        }
        die();
        //return (!empty($result)) ? json_decode($result) : null;
    }

    /**
     * Выдаем не обработанные заказы в формате JSON
     * @return array
     */
    static function getNewOrdersJson()
    {
        $data = OrderExtendModel::getListFinishOrder();

        if (!empty($data))
        {
            $text_json = json_encode($data, JSON_UNESCAPED_UNICODE);
            \app\models\Log::setMessage('send_last_order.log', $text_json);
        }

        return array('status' => 'success', 'data' => $data);
    }
}
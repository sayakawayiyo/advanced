<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/18
 * Time: 18:55
 */

return [
    'class' => 'yii\web\Response',
    'on beforeSend' => function ($event) {
        /**
         * @var $response \yii\web\Response
         */
        $response = $event->sender;
        $response->data = [
            'code' => $response->getStatusCode(),
            'data' => $response->data,
            'message' => $response->statusText
        ];
        $response->format = yii\web\Response::FORMAT_JSON;
    },

    //统一response响应
//    'class' => 'yii\web\Response',
//    'on beforeSend' => function ($event) {
//        /**
//         * @var $response \yii\web\Response
//         */
//        $response = $event->sender;
//        $code = $response->getStatusCode();
//        $msg = $response->statusText;
//
//        $rdata = [];
//
//        if ($code != 200) {
//            $response->setStatusCode(200);
//            $rdata['msg'] = $msg;
//            $rdata['code'] = $code;
//        } else {
//            $data = $response->data;
//            if (isset($data['code'])) {
//                $rdata['code'] = $data['code'];
//            }
//            if (isset($data['data'])) {
//                $rdata['data'] = $data['data'];
//            }
//            if (isset($data['msg'])) {
//                $rdata['msg'] = $data['msg'];
//            }
//        }
//        $response->data = $rdata;
//        $response->format = yii\web\Response::FORMAT_JSON;
//    },
];
<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 15:17
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //还需要返回请求的URL

    public function render(Exception $e)
    {
        if ($e instanceof BaseException) {
            //如果是自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            $this->code = 500;
            $this->msg = '服务器异常';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }

        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $request->url()
        ];

        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e)
    {
        //由于在config文件中关闭了日志的默认初始化行为关闭了，所以要进行重新配置
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}
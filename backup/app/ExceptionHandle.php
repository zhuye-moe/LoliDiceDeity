<?php
namespace app;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof \Exception ) {//这个地方是因为在www.bad-mews.qlworld\app\utils\Response.php  定义了一个自定义的异常返回方式，判断一下好不被后面的返回干扰
            if ($e->getCode() === 900) {
                $message = $e->getMessage();
            
                $result  = json_decode($message, true);
            
                $result  = json($result)->code(400);//表示客户端请求错误，一般是没有数据的情况
        
                return $result;
            }
        }
        


        if ($this->expectsJson($request)) {
            // $trace = $e->getTrace();

            // $func = function ($trace) {
            //     return Arr::except($trace, ['args']);
            // };
            $debug = [
                'message' =>$e->getMessage(),
                'exception'=>get_class($e),
                'file'=>$e->getFile(),
                'line'=>$e->getLine(),
                // 'trace'     => collect($trace)->map($func)->all(),
            ];
            return json([
                'code' => 500,
                'debug' => $debug,
            ])->code(500);
        } else {
            // 其他情况交给系统处理
            return parent::render($request, $e);
        }
    }

    public function expectsJson($request){
        return $request->isJson()||$request->isAjax()||$request->isGet()||$request->isPost()||$request->isPut()|| $request->isDelete();
    }
}

<?php
namespace app\utils;

/**
 * 公共返回类,暂时还没写好东西，还是先用着官方提供的助手方法
 */
class Response
{

    private $code = '';
    private $data = [];
    private $message = '';
    private $debug = [];
    private $cache = 0;

    /**
     * code/message/debug/cache/data
     * @param  [type] $name
     * @param  [type] $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        $param = isset($arguments[0]) ? $arguments[0] : [];
        if ($name === 'data') {
            $param = (array) $param;
        }
        $this->$name = $param;
        return $this;
    }

    /**
     * 正常结果返回
     *
     * @param  string $message
     * @return void
     */
    public function code($code = '')
    {
        $this->code = $code ?? 200;
        return $this;
    }

    /**
     * 错误结果返回
     *
     * @param  string $message
     * @return void
     */
    public function error($message = '', $exception = false)
    {
        $this->code || $this->code = 400;

        $message       = $message ? $message : $this->code;
        // $this->message = $this->trans($message);
        $this->message = $message;
        return $this->response($exception);
    }

    /**
     * 通过异常方式直接返回
     *
     * @param  string $message
     * @return void
     */
    public function exception($message = '')
    {
        return $this->error($message, true);
    }

    /**
     * 将 默认分页数据转换格式
     *
     * @param  array  $data
     * @return void
     */
    public function listPage($data = [])
    {
        
        $last                = ceil($data['total'] / $data['per_page']);
        $this->data['items'] = $data['data'];

        $this->data['page'] = [
            'total'   => (int) $data['total'],
            'current' => (int) $data['current_page'],
            'limit'   => (int) $data['per_page'],
            'last'    => (int) $last,
        ];
        return $this;
    }

    /**
     * 返回最终结果  后面找机会研究一下thinkphp应该怎么写
     *
     * @param  bool   $exception
     * @return void
     */
    public function response($exception = false)
    {
        $param = [
            'message' => $this->message,
            'data'    => $this->data,
        ];
        isset($this->data['page']) && $page = $this->data['page'];
        

        $parse = $this->valueToString($param);

        isset($page) && $parse['data']['page'] = $page;

        $result = [
            'code'    => $this->code,
            'message' => $parse['message'],
            'data'    => $parse['data'],
            'cache'   => $this->cache,
        ];

        $this->debug && $result['debug'] = $this->debug;

        $result = array_filter($result);
        if (empty($result['data'])) {
            $result['data'] = [];
        }
        // if (env('APP_DEBUG') == false && $this->code != 201 && empty(request()->mw)) {
        //     $result = (new Rsa())->encrypt(json_encode($result));
        // }
        if ($exception === true) {
            $message = json_encode($result, JSON_UNESCAPED_UNICODE);
            
            throw new \Exception($message, 900);
            // throw new BusinessException(900, $message);
            // //BusinessException(0,"id不能为空");
            
        }
        return json($result);
    }

 /**
     * 正常结果返回
     *
     * @param  string $message
     * @return void
     */
    public function success($message = '')
    {

        $this->code || $this->code = 200;
        $message || $message       = $this->code;
        // $this->message = $this->trans($message);
        $this->message = $message;
        return $this->response();
    }

    /**
     * 使用laravel validator ，如果校验不通过，直接使用异常方式返回结果
     * laravel validator 相关文档
     * https://learnku.com/docs/laravel/5.8/validation/3899
     *
     * @param  array  $data
     * @param  array  $rule
     * @param  array  $message
     * @param  array  $attr
     * @return void
     */
    // public function validator($data = [], $rule = [], $message = [], $attr = [])
    // {
    //     array_walk($rule, function (&$value) {
    //         strstr($value, 'bail') || $value = 'bail|' . $value;
    //     });

    //     $validator = Validator::make($data, $rule, $message, $attr);
    //     if ($validator->fails()) {
    //         $error = $validator->errors()->first();
    //         return $this->exception($error);
    //     }

    //     return true;
    // }

    /**
     * 转换位对象
     *
     * @param  [type] $mixture
     * @param  int    $depth
     * @return void
     */
    private function toObject($mixture = null, $depth = 0)
    {
        $func = false;
        $func = function ($mixture, $depth, $depth_count) use (&$func) {
            $obj = new \stdClass();
            if (is_object($mixture)) {
                $mixture = get_object_vars($mixture);
            }
            if (is_array($mixture)) {
                foreach ($mixture as $key => $value) {
                    if (is_array($value) && ($depth === 0 || $depth !== 0 && $depth_count < $depth)) {
                        $value = $func($value, $depth, $depth_count + 1);
                    }
                    $obj->key = $value;
                }
            }
            return $obj;
        };
        return $func($mixture, $depth, 1);
    }

    /**
     * 转换提示语
     * @param  string $message
     * @return void
     */
    // private function trans($message = '')
    // {
    //     $key  = 'response.' . $message;
    //     $lang = trans($key);

    //     if ($lang !== $key) {
    //         return $lang;
    //     }
    //     $lang   = trans('response');
    //     $params = explode('.', $message);
    //     $format = $lang['format'];

    //     $trans    = 0;
    //     $language = \App::getLocale();
    //     for ($i = 1; $i <= 5; $i++) {
    //         $value = $params[$i - 1] ?? '';
    //         $temp  = $lang[$value] ?? $value;
    //         $mark  = ':' . $i;
    //         if (!isset($lang[$value]) && isset($params[$i - 1])) {
    //             $trans++;
    //         }
    //         if ($language == 'en') {
    //             $format = trim(str_replace($mark, ucfirst($temp) . ' ', $format));
    //         } else {
    //             $format = str_replace($mark, $temp, $format);
    //         }
    //     }

    //     if ($trans === count($params)) {
    //         $format = $message;
    //     }

    //     return $format;
    // }

    /**
     * 所有数据转换为字符串
     *
     * @param  [type] $mixture
     * @param  array  $ext_params
     * @return void
     */
    private function valueToString($mixture, $ext_params = [])
    {
        return $mixture;
    }
}
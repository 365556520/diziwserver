<?php
namespace App\Http\Middleware;
use Closure;
use Response;
class EnableCrossRequestMiddleware
{
    /**
     * 跨域自定义中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $origin = ['*'];
        $response->header('Access-Control-Allow-Origin',$origin);
        $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
        $response->header('Access-Control-Allow-Methods','GET,POST,PATCH,PUT,OPTIONS,DELETE');// 允许请求的类型
        $response->header('Access-Control-Allow-Credentials','true'); // 设置是否允许发送 cookies
        // 设置允许自定义请求头的字段
        $response->header('Access-Control-Allow-Headers','Origin,Content-Type,X-Requested-With,Content-Type,Accept,Authorization,Cookie, X-CSRF-TOKEN,X-XSRF-TOKEN');
        return $response;
    }
}

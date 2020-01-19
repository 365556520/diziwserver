<?php
namespace App\Http\Middleware;
use Closure;
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
        $response->header('Access-Control-Expose-Headers','Authorization,authenticated');
        $response->header('Access-Control-Allow-Methods','GET,POST,PATCH,PUT,OPTIONS');// 允许请求的类型
        $response->header('Access-Control-Allow-Credentials','true'); // 设置是否允许发送 cookies
        // 设置允许自定义请求头的字段
        $response->header('Access-Control-Allow-Headers','Origin,Authorization,X-Requested-With,Content-Type,Accept,Access-Control-Allow-Origin,Access-token,Content-Length,Accept-Encoding,X-Requested-with,Origin,Access-Control-Allow-Methods');
        return $response;
    }
}

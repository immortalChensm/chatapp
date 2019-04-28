<?php

namespace App\Http\Middleware;

use App\Photos;
use Closure;

class verifyPhotos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $photo = Photos::where("photoId","=",$request->photoId)->first();
        if ($photo->userType==1){
            return response()->json(['code'=>0,'message'=>'用户发布的相册禁止修改！']);
        }
        return $next($request);
    }
}

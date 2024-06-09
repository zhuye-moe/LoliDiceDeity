<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;
use tp5er\think\auth\access\Authorizable;
use tp5er\think\auth\Authenticatable;
use tp5er\think\auth\Contracts\Authenticatable as AuthenticatableContract;
use tp5er\think\auth\Contracts\Authorizable as AuthorizableContract;
use tp5er\think\auth\jwt\contracts\JWTSubject as JWTSubjectContract;
use tp5er\think\auth\jwt\JWTSubject;
use tp5er\think\auth\sanctum\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubjectContract
{
    use Authenticatable,HasApiTokens,Authorizable,JWTSubject;
}

<?php 
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
        'user_id'             => (int) $user->id,
        'username'       => $user->username,
        'email'          => $user->email,
        'date_created'   => $user->created_at,
        'date_modified'  => $user->updated_at,
        'picture_url'    => $user->avatar
        ];
    }
}
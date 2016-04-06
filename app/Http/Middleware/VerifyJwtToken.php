<? php 

namespace Suyabay\Http\Middleware;

use Firebase\jwt\jwt;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\ApiPagesController;

class VerifyJwtToken
{
    /**
     * Middleware invokable class method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        if (!$request->hasHeader('authorization')) {
            return $response->withJson(['message' => 'User unauthorized due to unprovided token'], 401);
        }

        $userJwt = $this->getUserToken($request);
        $jwtToken = JWT::decode($userJwt, getenv('APP_SECRET'), [getenv('JWT_ALGORITHM')]);
        $request = $request->withAttribute('user', $user);
        $request = $request->withAttribute('token_jti', $jwtToken->jti);
        return $next($request, $response);
    }
    /**
     * Get user token from request header.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     *
     * @throws \UnexpectedValueException
     *
     * @return string
     */
    public function getUserToken($request)
    {
        // Get the authorization header value in other to retrieve the token
        $authHeader = $request->getHeader('authorization');
        list($userJwt) = sscanf($authHeader[0], 'Bearer %s');
        if (!$userJwt) {
            return $response->withJson(['message' => 'User unauthorized due to unprovided token'], 401);
        }
        return $userJwt;
    }
}
Status 
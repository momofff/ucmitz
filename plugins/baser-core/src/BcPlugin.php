<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS User Community <https://basercms.net/community/>
 *
 * @copyright     Copyright (c) baserCMS User Community
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       http://basercms.net/license/index.html MIT License
 */

namespace BaserCore;
use Cake\Core\BasePlugin;
use Cake\Routing\Route\InflectedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

/**
 * Class plugin
 * @package BaserCore
 */
class BcPlugin extends BasePlugin
{
    /**
     * @param \Cake\Routing\RouteBuilder $routes
     */
    public function routes($routes): void
    {
        $path = '/baser';
        Router::plugin(
            $this->name,
            ['path' =>  $path],
            function (RouteBuilder $routes) {
                $path = env('BC_ADMIN_PREFIX', '/admin');
                if($this->name !== 'BaserCore') {
                    $path .= '/' . Inflector::dasherize($this->name);
                }
                $routes->prefix(
                    'Admin',
                    ['path' => $path],
                    function (RouteBuilder $routes) {
                        $routes->connect('', ['controller' => 'Dashboard', 'action' => 'index']);
                        // CakePHPのデフォルトで /index が省略する仕様のため、URLを生成する際は、強制的に /index を付ける仕様に変更
                        $routes->connect('/{controller}/index', [], ['routeClass' => InflectedRoute::class]);
                        $routes->fallbacks(InflectedRoute::class);
                    }
                );
            }
        );
        parent::routes($routes);
    }
}

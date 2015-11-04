<?php

namespace yii\easyii\modules\menu\api;

use yii\easyii\modules\menu\models\MenuItem;
use yii\easyii\modules\menu\models\Menu as MenuModel;
use yii\base\ErrorException;
use yii\easyii\components\API;

/**
 * Class Menu
 * @package app\easyii\modules\menu\api
 *
 * @method static string|null getPageNameByPath(string $path)
 */
class Menu extends API
{
    /**
     * @var array
     */
    private $_items;

    /**
     * @param $id_slug menu id or slug
     * @param int $parent_id
     * @param null $menu_id
     * @param null $context
     * @return array
     * @internal param array $options
     */
    public function api_items($id_slug, $context = null, $parent_id = 0, $menu_id = null)
    {
        if($menu_id === null) {
            /** @var MenuModel $menu */
            $menu = MenuModel::find()->where(["slug" => $id_slug])->one();
            $menu_id = $menu->menu_id;
        }

        $items = MenuItem::find()->where(['parent_id' => $parent_id, 'menu_id' => $menu_id])->status(MenuItem::STATUS_ON)->orderBy(["order_num" => SORT_ASC])->all();

        $return = [];
        foreach($items as $item) {
            $return[] = [
                'label' => $item->label,
                'url' => $item->path,
                'active' => $context->route == trim($item->path, '/'),
                'items' => $this->api_items($id_slug, $context, $item->primaryKey, $menu_id)
            ];
        }

        return $return;
    }


    /**
     * Get page name by path
     *
     * @param $path
     * @return mixed|null
     */
    public function api_getPageNameByPath($path)
    {
        $menuItem = MenuItem::find()->where(["path" => $path])->one();

        if($menuItem) {
            return $menuItem->label;
        } else {
            return null;
        }
    }

}
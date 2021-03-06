<?php
/**
 * @copyright Copyright (C) 2015 AIZAWA Hina
 * @license https://github.com/fetus-hina/fest.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use yii\web\AssetBundle;

class ZxcvbnAsset extends AssetBundle
{
    public $sourcePath = '@bower/zxcvbn/dist';
    public $js = [
        'zxcvbn.js'
    ];
}

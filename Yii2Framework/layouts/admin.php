<?php
use yii\helpers\Html;
use app\assets\AdminAsset;
use app\config\widgets\Nav;
use app\config\widgets\Alert;
use app\config\widgets\Breadcrumbs;
use app\modules\site\models\SRL\SiteSettingsSRL;
use app\config\components\functions;
/* @var $this \yii\web\View */
/* @var $content string */
AdminAsset::register($this);
$settings    = SiteSettingsSRL::get();
$user        = Yii::$app->user;
$moduleUsers = functions::getModule('users');
$this->beginPage();
$title       = [$settings->title];
$breadcrumbs = [];
if (isset($this->params['breadcrumbs'])) {
    $breadcrumbs = $this->params['breadcrumbs'];
}
foreach ($breadcrumbs as $breadcrumb) {
    if (is_string($breadcrumb)) {
        $title[] = $breadcrumb;
    }
    else if (is_array($breadcrumb) && isset($breadcrumb['label'])) {
        $title[] = $breadcrumb['label'];
    }
}
$this->title = implode(' / ', $title);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <link rel="shortcut icon" type="image/ico" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <title><?= $this->title ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <script>var urlLoading = '<?= Yii::getAlias('@web/themes/default/images/loading.gif') ?>';</script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header <?= (isset($_COOKIE['cls']) ? ' h' : '') ?>">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?= Html::a($settings->title, ['/dashboard/default/index'], ['class' => 'navbar-brand']) ?>
                </div>
                <ul class="nav navbar-top-links navbar-right hidden-xs">
                    <li><a onclick="toggleMenuCookie();"><i class="fa fa-bars"></i></a></li>
                    <li><a style="cursor: default;direction: ltr;">امروز: <?= functions::datestring() ?></a></li>
                    <li><a style="cursor: default;direction: ltr;"><span id="hours" style="width: 20px;display: inline-block;text-align: center;"></span>:<span id="min" style="width: 20px;display: inline-block;text-align: center;"></span>:<span id="sec" style="width: 20px;display: inline-block;text-align: center;"></span></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><?= Html::a('<i class="fa fa-fw fa-user"></i> ' . Yii::t('users', 'Profile'), ['/users/profile/index']) ?></li>
                    <li><?= Html::a('<i class="fa fa-fw fa-sign-out-alt"></i> ' . Yii::t('users', 'Logout'), ['/users/auth/logout'], ['data' => ['method' => 'post']]) ?></li>
                </ul>
            </nav>
            <div class="sidebar <?= (isset($_COOKIE['cls']) ? ' h' : '') ?>" role="navigation">
                <div class="sidebar-nav navbar-collapse collapse">
                    <ul class="nav" id="side-menu">
                        <?php
                        echo $user->can('Dashboard')                  ? '<li>' . Html::a('<i class="fa fa-fw fa-tachometer-alt"></i> ' . Yii::t('dashboard', 'Dashboard'), ['/dashboard/default/index'])                       . '</li>' : '';
                        echo $user->can('Users')                      ? '<li>' . Html::a('<i class="fa fa-fw fa-users"></i> ' . Yii::t('users', 'Users'), ['/users/users/index'])                                              . '</li>' : '';
                        echo $user->can('Tcoding', ['idnoe' => 1])    ? '<li>' . Html::a('<i class="fa fa-fw fa-hotel"></i> ' . Yii::t('coding', 'Types of rooms'), ['/coding/tcoding/index', 'idnoe' => 1])                   . '</li>' : '';
                        echo $user->can('Tcoding', ['idnoe' => 2])    ? '<li>' . Html::a('<i class="fa fa-fw fa-store-alt"></i> ' . Yii::t('coding', 'Rooms'), ['/coding/tcoding/index', 'idnoe' => 2])                        . '</li>' : '';
                        echo $user->can('Tcoding', ['idnoe' => 4])    ? '<li>' . Html::a('<i class="fa fa-fw fa-percent"></i> ' . Yii::t('coding', 'Discounts'), ['/coding/tcoding/index', 'idnoe' => 4])                      . '</li>' : '';
                        echo $user->can('Tcoding', ['idnoe' => 6])    ? '<li>' . Html::a('<i class="fa fa-fw fa-lock"></i> ' . Yii::t('coding', 'Locks'), ['/coding/tcoding/index', 'idnoe' => 6])                             . '</li>' : '';
                        echo $user->can('Reservation', ['idp1' => 2]) ? '<li>' . Html::a('<i class="fa fa-fw fa-ticket-alt"></i> ' . Yii::t('coding', 'Definitive reservations'), ['/coding/reservations/index', 'idp1' => 2]) . '</li>' : '';
                        echo $user->can('Reservation', ['idp1' => 1]) ? '<li>' . Html::a('<i class="fa fa-fw fa-history"></i> ' . Yii::t('coding', 'Ongoing reservations'), ['/coding/reservations/index', 'idp1' => 1])       . '</li>' : '';
                        echo $user->can('Reservation', ['idp1' => 3]) ? '<li>' . Html::a('<i class="fa fa-fw fa-times"></i> ' . Yii::t('coding', 'Canceled reservations'), ['/coding/reservations/index', 'idp1' => 3])        . '</li>' : '';
                        echo $user->can('Sms')                        ? '<li>' . Html::a('<i class="fa fa-fw fa-envelope"></i> ' . Yii::t('sms', 'Sms'), ['/sms/management/index'])                                            . '</li>' : '';
                        echo $user->can('SmsSettings')                ? '<li>' . Html::a('<i class="fa fa-fw fa-envelope"></i> ' . Yii::t('sms', 'Sms Settings'), ['/sms/settings/index'])                                     . '</li>' : '';
                        echo $user->can('Email')                      ? '<li>' . Html::a('<i class="fa fa-fw fa-at"></i> ' . Yii::t('emails', 'Emails'), ['/emails/management/index'])                                         . '</li>' : '';
                        echo $user->can('EmailSettings')              ? '<li>' . Html::a('<i class="fa fa-fw fa-at"></i> ' . Yii::t('emails', 'Emails Settings'), ['/emails/settings/index'])                                  . '</li>' : '';
                        echo $user->can('SiteSettings')               ? '<li>' . Html::a('<i class="fa fa-fw fa-cogs"></i> ' . Yii::t('site', 'Site Settings'), ['/site/settings/index'])                                      . '</li>' : '';
                        ?>
                        <li><?= Html::a('<i class="fa fa-fw fa-globe"></i> ' . Yii::t('site', 'View Site'), ['/site/default/index'], ['target' => '_blank']) ?></li>
                        <li class="visible-xs"><?= Html::a('<i class="fa fa-fw fa-sign-out-alt"></i> ' . Yii::t('users', 'Logout'), ['/users/auth/logout'], ['data' => ['method' => 'post']]) ?></li>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper" class="<?= (isset($_COOKIE['cls']) ? ' h' : '') ?>">
                <?= Breadcrumbs::widget(['links' => $breadcrumbs]) ?>
                <div class="container-fluid">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
        <div id="modelIndex0" class="modal" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header white" style="background: #1bbc9b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <span></span>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer bg-white" style="padding: 8px 15px;">
                        <a class="btn btn-sm btn-default" data-dismiss="modal">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php
$this->endPage();

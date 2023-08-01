<div class="sidebar col-xl-2 col-lg-3 col-md-4 col-12">
    <div class="sidebar-top">
        <!-- <img class="sidebar-top__logo" src="/assets/faciocms.transparent.png" alt=""> -->
        <div class="padding text-center">
            <h1 class="sidebar-top__title"><a href="/admin">FacioCMS</a></h1>
            <h5 class="sidebar-top__subtitle">v.<?php echo $cms->generator_version; ?></h5>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin">
                    <em class="fas fa-home"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Home'); ?></span>
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin/pages">
                    <em class="fas fa-newspaper"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Pages'); ?></span>
                </a>
            </li>

            <?php if($cms->HasAtLeast("Admin")): ?>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin/users">
                    <em class="fas fa-users"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Users'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($cms->HasAtLeast("Moderator")): ?>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin/layouts">
                    <em class="fas fa-layer-group"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Layouts'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($cms->HasAtLeast("Super Admin")): ?>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin/plugins">
                    <em class="fas fa-plug"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Plugins'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($cms->HasAtLeast("Admin")): ?>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/admin/settings">
                    <em class="fas fa-cog"></em> <span class="sidebar-nav-item__title"><?php $cms->PrintTranslate('Settings'); ?></span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="sidebar-bottom padding">
        <div class="sidebar-bottom-left">
            <img class="sidebar-bottom-left__avatar" src="<?php echo $cms->GetUserAvatar(); ?>" alt="">
        </div>

        <div class="sidebar-bottom-right">
            <header class="sidebar-bottom-right__username"> <strong><?php echo $cms->user["username"]; ?></strong></header>
            <a class="sidebar-bottom-right__logout link mr-2" href="/admin/account"> <em class="fas fa-user"></em> </a>
            <a class="sidebar-bottom-right__logout link" href="/admin/logout"><em class="fas fa-sign-out-alt"></em> <?php $cms->PrintTranslate('Logout'); ?> </a>
        </div>
    </div>
</div>
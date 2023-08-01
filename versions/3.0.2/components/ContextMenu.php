<div class="context-menu">
    <header class="context-menu__title">FacioCMS</header>
    <span class="thin-line"></span>
    <div class="context-options">
        <button 
            @click="() => document.execCommand('copy')  && window.hideContextMenu()" 
            class="context-options__button">
            <em class="fas fa-copy"></em> <?php $cms->PrintTranslate('Copy'); ?>
        </button>
        
        <button 
            @click="() => document.execCommand('cut')   && window.hideContextMenu()" 
            class="context-options__button">
            <em class="fas fa-cut"></em> <?php $cms->PrintTranslate('Cut'); ?>
        </button>
        
        <button 
            @click="() => document.execCommand('paste') && window.hideContextMenu()" 
            class="context-options__button">
            <em class="fas fa-paste"></em> <?php $cms->PrintTranslate('Paste'); ?>
        </button>
        
        <button 
            @click="() => window.history.go(-1)" 
            class="context-options__button">
            <em class="fas fa-arrow-left"></em> <?php $cms->PrintTranslate('Prev'); ?>
        </button>
        
        <button 
            @click="() => window.history.go(1)" 
            class="context-options__button">
            <em class="fas fa-arrow-right"></em> <?php $cms->PrintTranslate('Next'); ?>
        </button>
        
        <button 
            @click="() => window.location.href = window.location.origin + '/admin/logout'" 
            class="context-options__button">
            <em class="fas fa-sign-out-alt"></em> <?php $cms->PrintTranslate('Logout'); ?>
        </button>
        
        <button 
            @click="() => window.location.href = window.location.origin + '/help'" 
            class="context-options__button">
            <em class="fas fa-question"></em> <?php $cms->PrintTranslate('Help'); ?>
        </button>
    </div>
    <span class="thin-line"></span>
    <header class="context-menu__footer">FacioCMS v.<?php echo $cms->generator_version; ?> </header>
</div>
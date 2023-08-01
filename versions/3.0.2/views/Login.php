<div class="view-container" id="login-container">
    
    <div class="cms-form">

        <h1 class="header"><?php $cms->PrintTranslate('Login'); ?></h1>
        <span class="hr-line"></span>

        <div class="form-group">
            <label for="username" class="form-label"><?php $cms->PrintTranslate('Username'); ?></label>
            <input id="username" type="text" class="form-input" v-model="forms.auth.signIn.username"> 
        </div>

        <div class="form-group">
            <label for="password" class="form-label"><?php $cms->PrintTranslate('Password'); ?></label>
            <input id="password" type="password" class="form-input" v-model="forms.auth.signIn.password"> 
        </div>

        <span class="hr-line"></span>

        <button class="cms-btn" @click="signIn"><?php $cms->PrintTranslate('Login'); ?></button>    
        
        <span class="info">{{ info.auth.signIn.error }}</span>

    </div>
    
    <?php $cms->IncludeComponent('Powered'); ?>

</div>
<script>window.onScriptLoaded(() => window.setDisplayView('users'))</script>

<div class="top-flex d-flex justify-content-between">
    <h1><?php $cms->PrintTranslate('Users'); ?></h1>
    <button class="cms-btn btn-iconed" @click="setView('create-user')" v-if="view === 'users'"> <?php $cms->PrintTranslate('CreateUser'); ?> <em class="fas fa-plus"></em></button>
    <button class="cms-btn btn-iconed" @click="setView('users')" v-if="view === 'create-user'"> <?php $cms->PrintTranslate('Back'); ?> <em class="fas fa-arrow-left"></em></button>
</div>

<div class="users-container">
    <?php $users = $cms->GetAllUsers(); ?>

    <?php if(empty($users)): ?>
        <div class="center-message mt-5 mb-5">
            <em class="fas fa-exclamation-triangle mb-3 logo-icon"></em>

            <h3><?php $cms->PrintTranslate('txt_13'); ?></h3>
            <h5 class="gray"><?php $cms->PrintTranslate('txt_14'); ?></h5>
        </div>
    <?php else: ?>
        <div class="users-view" v-if="view == 'users'">
            <h5 class="count-desc mb-4"> <em class="fas fa-users"></em> <?php $cms->PrintTranslate('txt_15'); ?>: <span class="count-red"><?php echo count($users); ?></span> </h5>

            <div class="user-container">
                <div class="user darken">
                    <div class="user-content">
                        <div class="user-top row">
                            <div class="col-md-3">
                                <strong class="user__title"><?php $cms->PrintTranslate('Username'); ?></strong> 
                            </div>

                            <div class="col-md-7">
                                <strong class="user__title"><?php $cms->PrintTranslate('Role'); ?></strong>
                            </div>

                            <div class="col-md-2 controls">
                            <strong class="user__title"><?php $cms->PrintTranslate('Other'); ?></strong>
                            </div>
                        </div> 
                    </div>
                </div>

                <?php foreach($users as $user): ?>
                    <?php
                        $username = $user["username"];
                        $id = $user["id"];
                        $perm_level = $user["permissions_level"];    
                    ?>

                    <div class="user">
                        <div class="user-content">
                            <div class="user-top row">
                                <div class="col-md-3">
                                    <header class="user__title"><?php echo $username; ?> </header> 
                                </div>

                                <div class="col-md-7">
                                    <strong>(<?php echo $cms->GetUserRoleByPermissionLevel($perm_level); ?>)</strong>
                                </div>

                                <div class="col-md-2 controls">
                                    <?php /* Cannot delete super admin user */ ?>
                                    <?php if($perm_level != 4): ?>
                                        <button class="times-tool-btn" @click="deleteUser(<?php echo $id; ?>)"><em class="fas fa-trash"></em></button>
                                    <?php endif; ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-center">
                    <button class="cms-btn mt-2" @click="setView('create-user')">  <em class="fas fa-plus no"></em></button>
                </div>
            </div>
        </div>

        <div class="create-user-view" v-else-if="view == 'create-user'">
            <form class="create-user cms-form full-width">
                <h3 class="mb-3"><?php $cms->PrintTranslate('CreateUser'); ?></h3>

                <div class="form-group">
                    <label class="form-label" for="username"><?php $cms->PrintTranslate('Username'); ?></label>
                    <input id="username" type="text" class="form-input" v-model="forms.auth.createUser.username"> 
                </div>

                <div class="form-group">
                    <label class="form-label" for="email"><?php $cms->PrintTranslate('Email'); ?></label>
                    <input id="email" type="email" class="form-input" v-model="forms.auth.createUser.email"> 
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="password"><?php $cms->PrintTranslate('Password'); ?></label>
                            <input id="password" :type="showPassword ? 'text' : 'password'" class="form-input" v-model="forms.auth.createUser.password"> 
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="c_password"><?php $cms->PrintTranslate('Confirm_Password'); ?></label>
                            <input id="c_password" :type="showPassword ? 'text' : 'password'" class="form-input" v-model="forms.auth.createUser.confirm_password"> 
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label transparent" for="">.</label>

                            <div class="buttons">
                                <button type="button" class="cms-btn cms-btn-wh-equal" @click="randomizePasswordForUserCreation"><em class="fas fa-dice no"></em></button>
                                <button type="button" class="cms-btn cms-btn-wh-equal" @click="toggleShowPassword"><em :class="`fas ${showPassword ? 'fa-eye-slash' : 'fa-eye'} no`"></em></button>
                            </div>
                        </div>
                    </div>
                </div>

                <span class="warning mb-3" v-if="forms.auth.createUser.password != '' && forms.auth.createUser.password != forms.auth.createUser.confirm_password"> <em class="fas fa-exclamation-triangle"></em> Passwords doesn't match! </span>

                <div class="form-group">
                    <label class="form-label" for="role"><?php $cms->PrintTranslate('Role'); ?></label>
                    <select value="Viewer" id="role" class="form-input" v-model="forms.auth.createUser.role"> 
                        <option value="Moderator" selected>Moderator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <button 
                    type="button" 
                    class="cms-btn mt-3" 
                    @click="createUser">
                    <?php $cms->PrintTranslate('CreateUser'); ?></em>
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php
    namespace FacioCMS\Versions\v3\API;

    /**
     * @name Router
     * Router gives rotues to API
     */
    trait Router {
        public function HandleRequestIfIsAPI(): void {
            if($this->IsAPIRequest()) {
                $uri = $_SERVER["REQUEST_URI"];
                $uri_path_parts = explode("/", $uri);

                $this->HandleRoute($uri_path_parts[2]);
            }
        }

        // Handle all request that matches https://website.url/api/<route>
        public function HandleRoute(string $route): void {
            header('Content-Type: text/plain');

            $res = "";
            switch($route) {
                case "cms-version": {
                    $res = $this->HandleAPI_Version();
                } break;
                case "status": {
                    $res = $this->HandleAPI_Status();
                } break;
                case "sign-in": {
                    $res = $this->HandleAPI_Login();
                } break;
                case "page-save": {
                    $res = $this->HandleAPI_PageSave();
                } break;
                case "save-settings": {
                    $res = $this->HandleAPI_SettingsSave();
                } break;
                case "create-page": {
                    $res = $this->HandleAPI_CreatePage();
                } break;
                case "delete-page": {
                    $res = $this->HandleAPI_DeletePage();
                } break;
                case "delete-meta-setting": {
                    $res = $this->HandleAPI_DeleteMetaSetting();
                } break;
                case "create-meta-setting": {
                    $res = $this->HandleAPI_CreateMetaSetting();
                } break;
                case "save-meta-setting": {
                    $res = $this->HandleAPI_SaveMetaSetting();
                } break;
                case "create-user": {
                    $res = $this->HandleAPI_CreateUser();
                } break;
                case "delete-user": {
                    $res = $this->HandleAPI_DeleteUser();
                } break;
                case "create-layout": {
                    $res = $this->HandleAPI_CreateLayout();
                } break;
                case "disk-usage": {
                    $res = $this->HandleAPI_DiskUsage();
                } break;
                case "delete-all-pages": {
                    $res = $this->HandleAPI_DeleteAllPages();
                } break;
                case "upload-gallery": {
                    $res = $this->HandleAPI_UploadGallery();
                } break;
                case "delete-gallery-item": {
                    $res = $this->HandleAPI_DeleteGalleryItem();
                } break;
                case "delete-layout": {
                    $res = $this->HandleAPI_DeleteLayout();
                } break;
                case "clear-cache": {
                    $res = $this->HandleAPI_ClearCache();
                } break;
                case "change-version": {
                    $res = $this->HandleAPI_ChangeVersion();
                } break;
            }

            echo gettype($res) == 'array' ? json_encode($res) : $res;

            exit();
        }
    }
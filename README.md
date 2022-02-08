# LARAVEL 8 QUİZ

### Homestead | Projede sürüm uyuşmazlığından kaynaklanan hatanın çözümü
```
    composer update
```
Not: Bu komutu proje dizninde çalıştırdıktan sonra Homestead'i yeniden başlatın!
```
    vagrant reload --provision
```

### Jetstream ekleme
```
    composer require laravel/jetstream
```

### Install Jetstream With Livewire
```
    php artisan jetstream:install livewire
```
### Migration
```
    php artisan migrate
```

### NPM install
```
    npm install
```
### NPM run dev
```
    npm run watch
```
### Fortify Password Length
vendor/laravel/fortify/src/Rules/Password.php
```
//istediğiniz şifre uzunluğu
protected $length = 6;
```
### Jetstream  Profile Photos ADD
config/jetstream.php
```
 'features' => [
        // Features::termsAndPrivacyPolicy(),
         Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],

```
Resimlerin kayıt olması için:
```
    php artisan storage:link
```
### Bootstrap Install
```
    npm i bootstrap
```
Bootstrap projeye dahil etmek için:
resources/css/app.css
içerisine komutu yazın.
```
    @import 'bootstrap';
```
JS dahil etmek için:
resources/js/app.js
```

```

### 


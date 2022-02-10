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

### Admin kullanıcısı oluşturma
database/migrations/users tablosu
```
 Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('type',['admin', 'user'])->default('user'); //type created 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
```
artisan ile tabloları yenileme
```
    php artisan migrate:fresh
```
Bu işlemi yaptığımızda tablomuz sıfırlanacaktır. Bunun olmamamsı için bir seed yazacağız.
### Seeders oluşturma
database/seeders/DatabaseSeeder.php
```
   public function run()
    {
        \App\Models\User::insert([
        'name' => 'Gazi Hataş',
        'email' => 'gazi@yandex.com',
        'email_verified_at' => now(),
        'type' => 'admin',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(5)->create(); // 5 adet üye üreteceğiz.
    }
}
```
Str::random() -> Fonksiyonunun çalışması için üsste path ekleyin.
use Illuminate\Support\Str;
Bu alan UserFactory.php dosyasını çağırıyor.
### UserFactory.php
Bize ilgili alanlar için üye oluşturuyor.
```
public function definition()
    {
        $types = ['admin','user'];
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'type' =>$types[rand(0,1)],
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
```

Bu sefer tabloları yeni aynı zamanda seed'i de devreye alıyoruz.
```
    php artisan migrate:fresh --seed
```
Sonuç olarak user tablosuna rastgele 5  kayıt oluşturukdu.
Her seferinde yeni kayıt oluşturmamıza gerek yok.
Artık üyelerin tipi amin ya da user.

## Middleware Oluşturma ve Route Yönlendirmeleri
**Admin sayfalarına user type Admin olanların ulaşabilmeleri için bir tane middleware yazacağız**
**Route muzda admin sayfaları için bu midleware'i aktif edelim.**

### Middleware oluşturma
```
    php artisan make:middleware isAdmin
```
app/Http/Middleware/isAdmin.php olarak oluşturuldu.
BU oluşturduğumuz middleware'e
```
 public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->type!=='admin')
        {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
```
### Oluşturduğumuz bu middleware'i KErnel.php de 'isAmin olarak'tanımlayalım.
app/Http/Kernel.php
```
     protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'isAdmin' => \App\Http\Middleware\isAdmin::class,
    ];
```

### Route Tanımlamasını yapalım
```

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/panel', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth', 'isAdmin'],'prefix' => 'admin',], function (){
    Route::get('deneme',function (){
     return "prefix testi";
    });
});
```

**/app/Providers/RouteServiceProvider.php dizininde değişikleri yapıyoruz** 
```
    //public const HOME = '/dashboard'; 
    public const HOME = '/panel';
```

## Quiz Tablosu oluşturmak ve Migration işlemleri

### migration işlemi ve fonksiyonları
``` php artisan make:migration quiz_migration ```
Normal migrate oluşturfduğumuzda migration dosyası iki tane fonksiyon ile geliyor.
- up : migrate ettiğimizde tabloyu oluşturur
- down : refresh ve destroy ettiğimizde bu kısım oluşturulur.

### migration oluşturulduğunda içindeki fonksiyonların dolu gelmesi için 2 tane migration parametresi  vardır.
1. --table parametresi
    -  ``` php artisan make:migration quiz_migration --table="quizzes" ```
    - --table parametresi up ve down fonksiyonlarına aynı schemayı verir.
2. --create parametresi 
    -  ``` php artisan make:migration quiz_migration --create="quizzes" ```
    -  --create ile oluşturulduğunda down olduğunda silme komutunu ekler.

**Bu iki yöntem de mantık olarak aynıdır. Fakat biz 2. yöntemi kullanacağız**
 ``` php artisan make:migration quiz_migration --create="quizzes" ```

### Quiz tablosunu oluşturmak
1. Migration komutu ile tablomuzu oluşturacağımız dosyayı oluşturuyoruz.
    - ``` php artisan make:migration quiz_migration --create="quizzes" ```
2. OLuşan migration dosyamızın içinde tablomuzu oluşturuyoruz.
    - ``` 
    public function up()
    {
        //Temel quiz tablomuz
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->enum('status',['publish','draft','passive'])->default('draft');
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }
    ```
3. Migration işlemimizi gerçekleştiriyoruz.
    - ``` php artisan migration ```
4. Tablomuz oluştu. 

### Quiz Tablosuna DamiData Ekleme
1. QuizSeeder oluşturma
    - ``` php artisan make:seeder QuizSeeder```
    - ```<?php

            namespace Database\Seeders;

            use Illuminate\Database\Seeder;

            class QuizSeeder extends Seeder
            {
                /**
                * Run the database seeds.
                *
                * @return void
                */
                public function run()
                {
                    \App\Models\Quiz::factory(10)->create();
                }
            }
        ```
2. QuizFactory oluşturma
    - ``` php artisan make:factory QuizFactory ```
    - ``` <?php

        namespace Database\Factories;

        use App\Models\Quiz;
        use Illuminate\Database\Eloquent\Factories\Factory;

        class QuizFactory extends Factory
        {
            /**
            * Define the model's default state.
            *
            * @return array
            */

            protected $model = Quiz::class;

            public function definition()
            {
                //ilgili tablomuzun ilgili sutunlarına atamaları yapıyoruz
                return [
                    'title' => $this->faker->sentence(rand(3,7)),
                    'description' => $this->faker->text(200),

                ];
            }
        }
        ```
3. Quiz Model Oluşturma
    - ``` php artisan make:model Quiz```
    - ``` <?php

            namespace Database\Factories;

            use App\Models\Quiz;
            use Illuminate\Database\Eloquent\Factories\Factory;

            class QuizFactory extends Factory
            {
                /**
                * Define the model's default state.
                *
                * @return array
                */

                protected $model = Quiz::class;

                public function definition()
                {
                    //ilgili tablomuzun ilgili sutunlarına atamaları yapıyoruz
                    return [
                        'title' => $this->faker->sentence(rand(3,7)),
                        'description' => $this->faker->text(200),

                    ];
                }
            }
        ```
4.  UserSeed oluşturma
    -  ``` php artisan make:seeder UserSeeders ```
    - ``` <?php

                namespace Database\Seeders;

                use Illuminate\Database\Seeder;
                use Illuminate\Support\Str;

                class UserSeeder extends Seeder
                {
                    /**
                    * Run the database seeds.
                    *
                    * @return void
                    */
                    public function run()
                    {
                        \App\Models\User::insert([
                            'name' => 'Gazi Hataş',
                            'email' => 'gazi@yandex.com',
                            'email_verified_at' => now(),
                            'type' => 'admin',
                            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                            'remember_token' => Str::random(10),
                            ]);

                        \App\Models\User::factory(5)->create();
                    }
                }
        ```
5. Seed işlemlerimizi veri tabanımıza uyguluyoruz
    - ``` php artisan migrate:fresh --seed ```
6. Bu kurduğumuz yapı ile seeder larımızı istediğimiz yerde çağırabiliriz.
    - ``` php artisan db:seed --class=QuizSeeder ```
    - ``` php artisan db:seed --class=UserSeeder ```